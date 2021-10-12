<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index($id = false)
    {
        if ($id) {
            $items = Item::find($id);
            $items->storage_path = url("/storage/");
        }else {
            $items = Item::all();
        }
        
        return response()->json([
            'success' => true,
            'message' =>'berhasil mendapatkan data Item',
            'data'    => $items
        ], 200);
    }

    public function store(Request $request)
    {
        $rules = [
                'name' => 'required',
                'unit' => 'required',
                'stock' => 'required|integer',
                'unit_price' => 'required|integer',
                'image' => 'required',
        ];
        $validator = validation_request($request,$rules);
        if(!$validator->success) return response()->json($validator,422);

        $item = Item::create([
            'name'     => $request->input('name'),
            'unit'   => $request->input('unit'),
            'stock'   => $request->input('stock'),
            'unit_price'   => $request->input('unit_price'),
            'images'   => $request->input('image'),
        ]);

        if ($item) {
            return response()->json([
                'success' => true,
                'message' => 'item Berhasil Disimpan!',
                'data' => $item
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'item Gagal Disimpan!',
            ], 400);
        }
    }

    public function update(Request $request,$item_id)
    {
        $rules = [
            'name' => 'required',
            'unit' => 'required',
            'stock' => 'required|integer',
            'unit_price' => 'required|integer',
            // 'image'   => 'required',
        ];
        $validator = validation_request($request,$rules);
        if(!$validator->success) return response()->json($validator,422);

        $item = Item::where('id',$item_id)->update([
            'name'     => $request->input('name'),
            'unit'   => $request->input('unit'),
            'stock'   => $request->input('stock'),
            'unit_price'   => $request->input('unit_price'),
            // 'images'   => $request->input('image'),
        ]);

        if ($item) {
            return response()->json([
                'success' => true,
                'message' => 'item Berhasil Disimpan!',
                'data' => $item
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'item Gagal Disimpan!',
            ], 400);
        }
    }

    function delete(Request $request, $id)
    {
        if($item = Item::find($id)){
            remove_file($item->images);
            $item->delete();
            return response()->json(['message'=>'success']);
        }
        return response()->json(['message'=>'failed'],501);
    }

    function upload_image(Request $request, $item_id=null)
    {
        $rules = [
            'image' => 'required|image',
        ];
        $validator = validation_request($request,$rules);
        if(!$validator->success) return response()->json($validator,422);

        $path = "items_image";
        $uploaded = upload_file($request->file('image'),$path);
        if ($item_id) {
            $item = Item::findOrFail($item_id);
            $item->images = $uploaded;
            $item->save();
        }

        if ($request->remove) {
            $request->request->add(['path'=>$request->remove]);
            $this->remove_image($request);
        }
        
        return response()->json([
            'success' => true,
            'message' => $uploaded ? 'gambar berhasil diupload!' : 'gambar gagal diupload!',
            'path'    => $uploaded
        ], $uploaded ? 200 : 400);
    }

    function remove_image(Request $request, $item_id=null)
    {
        $rules = [
            'path' => 'required',
        ];
        $validator = validation_request($request,$rules);
        if(!$validator->success) return response()->json($validator,422);

        return response()->json([
            'success' => true,
            'message' => remove_file($request->path) ? 'success' : 'failed'
        ], 200);
    }
}
