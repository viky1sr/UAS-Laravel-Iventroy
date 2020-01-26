<?php

namespace App\Http\Controllers;

use App\Category;
use App\Favorite;
use App\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');
        $category = Category::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');

        $favorites = Favorite::all();
        return view('favorites.index',compact('product','category'));
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
            'minggu' => 'required',
            'bulan' => 'required',
        ]);

        Favorite::create($request->all());
        return response()->json([
            'success'    => true,
            'message'    => 'favorites Created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        $product = Product::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');
        $category = Category::orderBy('nama','ASC')
            ->get()
            ->pluck('nama','id');

        $this->validate($request , [
            'bulan'       => 'required',
            'minggu'      => 'required',
            'product_id'  => 'required',
            'category_id' => 'required'
        ]);

        $fav = Favorite::findOrFail($favorite);
        $fav->update($request->all());
        return response()->json([
            'success'    => true,
            'message'    => 'Update Favorite Product'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete Faovirte Product'
        ]);
    }

    public function apiFavorites()
    {
        $favorites = Favorite::select('favorites.*');
        return \DataTables::eloquent($favorites)

            ->addColumn('product_id', function ($favorites){
                return $favorites->product->nama;
            })
            ->addColumn('category_id', function ($favorites) {
                return$favorites->category->nama;
            })
            ->addColumn('action', function($favorites){
                return
                    '<a onclick="deleteData('. $favorites->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['action','product_id','category_id'])->make(true);
    }
}
