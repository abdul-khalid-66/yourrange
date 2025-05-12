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

class ProductController extends Controller
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
        $product->load(['category', 'supplier', 'variants']);
        return view('app.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('variants');
        $categories = Category::orderBy('category_name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('app.product.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate the main product data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,out of stock',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'reorder_level' => 'nullable|integer|min:0',
            'variants' => 'required|array|min:1',
            'variants.*.id' => 'sometimes|exists:product_variants,id,product_id,' . $product->id,
            'variants.*.name' => 'required|string|max:100',
            // 'variants.*.sku' => 'required|string|max:100|unique:product_variants,sku,'.$request->variants.*.id.',id',
            'variants.*.price_sale' => 'required|numeric|min:0',
            'variants.*.price_cost' => 'required|numeric|min:0',
            'variants.*.status' => 'required|in:available,out of stock',
            'variants.*.stock_quantity' => 'required|integer|min:0',
            'variants.*.weight' => 'nullable|numeric|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Update the product
        $product->update($validated);

        // Handle variants
        $existingVariantIds = $product->variants->pluck('id')->toArray();
        $updatedVariantIds = [];

        foreach ($request->variants as $variantData) {
            if (isset($variantData['id']) && in_array($variantData['id'], $existingVariantIds)) {
                // Update existing variant
                $variant = $product->variants()->find($variantData['id']);
                $variant->update($variantData);
                $updatedVariantIds[] = $variantData['id'];
            } else {
                // Create new variant
                $newVariant = $product->variants()->create($variantData);
                $updatedVariantIds[] = $newVariant->id;
            }
        }

        // Delete variants that weren't included in the update
        $variantsToDelete = array_diff($existingVariantIds, $updatedVariantIds);
        if (!empty($variantsToDelete)) {
            $product->variants()->whereIn('id', $variantsToDelete)->delete();
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated image if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete the product (variants will be deleted automatically due to cascade)
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function lowStock()
    {
       
        $lowStockItems = ProductVariant::with('product')
        ->whereColumn('stock_quantity', '<', 'products.reorder_level')
        ->join('products', 'product_variants.product_id', '=', 'products.id')
        ->select('product_variants.*')
        ->get();
            
        return view('app.sales.inventory_control.low-stock', compact('lowStockItems'));

    }

}
