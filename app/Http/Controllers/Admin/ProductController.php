<?php
namespace App\Http\Controllers\Admin;

use Str;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'thumbnail' => 'required|image|max:2048',
            'images.*' => 'image|max:2048', // multiple images
        ]);

        // SIMPAN DATA PRODUK
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $this->generateUniqueSlug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'thumbnail' => $request->file('thumbnail')->store('products/thumbnail', 'public'),
        ]);

        // SIMPAN MULTIPLE IMAGES
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/gallery', 'public');
                $product->images()->create(['image' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }



    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            // 'status' => 'required|in:active,inactive',
            'thumbnail' => 'nullable|image|max:2048',
            'images.*' => 'image|max:2048',
        ]);

        $data = $request->only([
            'category_id',
            'name',
            'description',
            'price',
            'stock',
            // 'status'
        ]);

        $data['slug'] = $this->generateUniqueSlug($request->name);

        // replace thumbnail jika ada foto baru
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnail', 'public');
        }

        $product->update($data);

        // ADD new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/gallery', 'public');
                $product->images()->create(['image' => $path]);
            }
        }

        return redirect()->route('admin.products.edit', $product->id)->with('success', 'Product updated.');
    }



    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }

    public function deleteImage($productId, $imageId)
    {
        $product = Product::findOrFail($productId);

        $image = ProductImage::where('id', $imageId)
            ->where('product_id', $productId)
            ->firstOrFail();

        Storage::disk('public')->delete($image->image);

        $image->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['message' => 'Image deleted']);
        }

        return back()->with('success', 'Image removed');
    }



    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }


}

