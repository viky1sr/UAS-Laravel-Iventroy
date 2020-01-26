<?php

namespace App\Http\Controllers;

use PDF;
use App\Product;
use App\Product_Masuk;
use App\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductMasukController extends Controller
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

        $suppliers = Supplier::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');

        $invoice_data = Product_Masuk::all();
        return view('Product_Masuk.index', compact('products','suppliers','invoice_data'));

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
            'supplier_id'    => 'required',
            'qty'            => 'required',
            'tanggal'        => 'required'
        ]);

        Product_Masuk::create($request->all());

        $product = Product::findOrFail($request->product_id);
        $product->qty += $request->qty;
        $product->save();

        return response()->json([
            'success'    => true,
            'message'    => 'Products In Created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product_Masuk  $product_Masuk
     * @return \Illuminate\Http\Response
     */
    public function show(Product_Masuk $product_Masuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product_Masuk  $product_Masuk
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_Masuk $product_Masuk)
    {
        Product_Masuk::find($product_Masuk);
        return response()->json([
           'success' => true,
           'message' => 'Success editing product out'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product_Masuk  $product_Masuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_Masuk $product_Masuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product_Masuk  $product_Masuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_Masuk $product_Masuk)
    {
        $product_Masuk->delete();
        return response()->json([
           'success' => true,
           'message' => 'Succes Deleting product out!'
        ]);
    }

    public function apiProductsIn(){
        $product = Product_Masuk::all();

        return Datatables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->nama;
            })
            ->addColumn('supplier_name', function ($product){
                return $product->supplier->nama;
            })
            ->addColumn('action', function($product){
                return
                    '<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a> ';


            })
            ->rawColumns(['products_name','supplier_name','action'])->make(true);

    }

    public function exportProductMasukAll()
    {
        $product_masuk = Product_Masuk::all();
        $pdf = PDF::loadView('product_masuk.productMasukAllPDF',compact('product_masuk'));
        return $pdf->download('product_masuk.pdf');
    }

    public function exportProductMasuk($id)
    {
        $product_masuk = Product_Masuk::findOrFail($id);
        $pdf = PDF::loadView('product_masuk.productMasukPDF', compact('product_masuk'));
        return $pdf->download($product_masuk->id.'_product_masuk.pdf');
    }

}
