<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $data         = Product::active();
        $limit        = request()->get('limit');
        $productTitle = request()->get('title');

        if ($productTitle) {
            $data = $data->where('title', $productTitle);
        }

        $data = $data->paginate($limit);

        return ProductResource::collection($data);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $path          = $this->uploadFile($request, 'image', 'product');
                $data['image'] = Storage::url($path);
            }

            $product = Product::create($data);
            if ($product) {
                return response(['message' => 'Item has been created successfully', 'status' => 'success'], 201);
            }
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage(), 'status' => 'error'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {

            $data = $request->only(['title', 'description', 'price', 'image', 'status']);
            if ($request->hasFile('image')) {
                $this->deleteFile($product->image);
                $path          = $this->uploadFile($request, 'image', 'product');
                $data['image'] = Storage::url($path);
            }

            $products = $product->fill($data)->save();

            if ($products) {
                return response(['message' => 'Item has been updated successfully', 'status' => 'success'], 201);
            }
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage(), 'status' => 'error'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            if ($product->delete()) {
                $this->deleteFile($product->image);
                return response(['message' => 'Item has been deleted successfully', 'status' => 'success'], 200);
            }
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage(), 'status' => 'error'], 400);
        }
    }

    public function uploadFile($request, $file_name, $upload_dir)
    {
        if ($request->hasFile($file_name)) {
            $file     = $request->$file_name;
            $filename = time() . '-' . $file->getClientOriginalName();
            $up_path  = "$upload_dir";
            $path     = Storage::disk('public')->putFileAs($up_path, $file, $filename);

            //dd($path);
            if ($file->getError()) {
                return $file->getErrorMessage();
            }

            return $path;
        }
    }

    public function deleteFile($file)
    {
        $status = is_file(public_path($file)) ? unlink(public_path($file)) : false;
        return $status;
    }
}
