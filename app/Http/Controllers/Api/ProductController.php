<?php

namespace App\Http\Controllers\Api;

use App\Enum\Message;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseController
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
                $data['image'] = $path;
            }

            $product = Product::create($data);
            if ($product) {
                return $this->response(Message::SUCCESS, 'success', 201);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return $this->response(Message::ERROR, 'error', 400);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {

            $data = $request->only(['title', 'description', 'price', 'image', 'status']);
            if ($request->hasFile('image')) {
                $this->deleteFile($product->image);
                $path          = $this->uploadFile($request, 'image', 'product');
                $data['image'] = $path;
            }

            $products = $product->fill($data)->save();

            if ($products) {
                return $this->response(Message::SUCCESS, 'success', 201);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return $this->response(Message::ERROR, 'error', 400);
        }
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            if ($product->delete()) {
                //$this->deleteFile($product->image);
                return $this->response(Message::DELETE, 'success', 200);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return $this->response(Message::ERROR, 'error', 400);
        }
    }

    /**
     * @param $request
     * @param $file_name
     * @param $upload_dir
     * @return false|string
     */
    public function uploadFile($request, $file_name, $upload_dir)
    {
        if ($request->hasFile($file_name)) {
            $file     = $request->$file_name;
            $filename = time() . '-' . $file->getClientOriginalName();
            $up_path  = "$upload_dir";
            $path     = Storage::disk('public')->putFileAs($up_path, $file, $filename);

            if ($file->getError()) {
                return $file->getErrorMessage();
            }

            return $path;
        }
    }

    /**
     * @param $file
     * @return bool
     */
    public function deleteFile($file)
    {
        return Storage::disk('public')->delete($file);
    }
}
