<?php

namespace App\Http\Controllers;

use PDF;
use App\Customer;
use App\Product;
use App\Product_Keluar;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');

        $customers = Customer::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');

        $invoice_data = Product_Keluar::all();
        return view('product_keluar.index', compact('products','customers', 'invoice_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id'     => 'required',
            'customer_id'    => 'required',
            'qty'            => 'required',
            'tanggal'           => 'required'
        ]);

        Product_Keluar::create($request->all());

        $product = Product::findOrFail($request->product_id);
        $product->qty -= $request->qty;
        $product->save();

        return response()->json([
            'success'    => true,
            'message'    => 'Products Out Created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product_Keluar  $product_Keluar
     * @return \Illuminate\Http\Response
     */
    public function show(Product_Keluar $product_Keluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product_Keluar  $product_Keluar
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_Keluar $product_Keluar)
    {
        Product_Keluar::find($product_Keluar);
        return response()->json([
           'success' => true,
           'message' => 'Editing data success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product_Keluar  $product_Keluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_Keluar $product_Keluar)
    {
        $this->validate($request, [
        'product_id'     => 'required',
        'customer_id'    => 'required',
        'qty'            => 'required',
        'tanggal'           => 'required'
    ]);

        Product_Keluar::findOrFail($product_Keluar);
        $product_Keluar->update($request->all());

        $product = Product::findOrFail($request->product_id);
        $product->qty -= $request->qty;
        $product->update();

        return response()->json([
            'success'    => true,
            'message'    => 'Product Out Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product_Keluar  $product_Keluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_Keluar $product_Keluar)
    {
        $product_Keluar->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delet data product success'
        ]);
    }

    public function apiProductsOut(){
        $product = Product_Keluar::all();

        return Datatables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->nama;
            })
            ->addColumn('customer_name', function ($product){
                return $product->customer->nama;
            })
            ->addColumn('action', function($product){
                return
                    '<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['products_name','customer_name','action'])->make(true);

    }

    public function exportProductKeluarAll()
    {
        $product_keluar = Product_Keluar::all();
        $pdf = PDF::loadView('product_keluar.productKeluarAllPDF',compact('product_keluar'));
        return $pdf->download('product_keluar.pdf');
    }

    public function exportProductKeluar($id)
    {
        $product_keluar = Product_Keluar::findOrFail($id);
        $pdf = PDF::loadView('product_keluar.productKeluarPDF', compact('product_keluar'));
        return $pdf->download($product_keluar->id.'_product_keluar.pdf');
    }

}
