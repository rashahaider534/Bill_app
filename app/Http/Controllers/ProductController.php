<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $sections = Section::all();
        return view('Product.products', compact(['products', 'sections']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::where('name', $request->name)
            ->where('section_id', $request->section_id)
            ->first();

        if ($product) {
            return redirect('/product')->with('error', 'المنتج موجود ');
        } else {
            $newproduct = new Product();
            $newproduct->name = $request->name;
            $newproduct->section_id = $request->section_id;
            $newproduct->description = $request->description;

            $newproduct->save();
            return redirect('/product')->with('success', 'تم إضافة المنتج بنجاح');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product=Product::where('id',$product->id)->first();
        $product->update(
            [
                'name'=>$request->name,
                'section_id'=>$request->section_id,
                'description'=>$request->description
            ]
            );
            return redirect('/product');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product=Product::where('id',$product->id)->first();
        $product->delete();
        return redirect('/product');
    }
}
