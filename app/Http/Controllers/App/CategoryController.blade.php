<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryLog;
use App\Models\Supplier;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       

        return view('app.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view('app.admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

    }

  

}
