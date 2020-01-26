<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');

        $producs = Product::all();
        return view('products.index', compact('category'));
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
        $category = Category::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');

        $this->validate($request , [
            'nama'          => 'required|string',
            'harga'         => 'required',
            'qty'           => 'required',
            'category_id'   => 'required',
        ]);

        Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Products Created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        Category::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');

        Product::find($product);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $category = Category::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');

        $this->validate($request , [
            'nama'          => 'required|string',
            'harga'         => 'required',
            'qty'           => 'required',
            'category_id'   => 'required',
        ]);
        $product->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Products Update'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
           'success' =>  true,
           'message' => 'Success delete product'
        ]);
    }

    public function apiProducts(){
        $product = Product::all();

        return Datatables::of($product)
            ->addColumn('category_id', function ($product){
                return $product->category->nama;
            })
//            ->addColumn('harga', function ($product) {
//                return number_format($product->product->harga,2);
//            })
            ->addColumn('action', function($product){
                return
                    '<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['category_id','action','harga'])->make(true);

    }
}
