<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index()
    {
        return view('app.admin.product.index');
    }

    public function create()
    {
       
        return view('app.admin.product.create');
    }


    public function store(Request $request)
    {
       
    }


    public function show(Product $product)
    {
      
    }


    public function edit(Product $product)
    {
       
    }


    public function update(Request $request, Product $product)
    {
       
    }


    public function destroy(Product $product)
    {

    }

  

}
