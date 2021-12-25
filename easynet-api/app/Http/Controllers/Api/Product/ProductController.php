<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Product;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function($request, $next){

           if(Gate::allows('product')) return $next($request);
           abort(403, 'Anda tidak memiliki cukup hak akses');
       });
    }
    public function index()
    {
        //
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
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'short_name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $new_product = new Product;
        $new_product->name = $request->name;
        $new_product->short_name = strtoupper($request->short_name);
        $new_product->description = strip_tags($request->description);
        if($request->file('cover')){
            $file = $request->file('cover')->store(trim(preg_replace('/\s+/', '', '/image/products/')).strtoupper($new_product->short_name), 'public');
          $new_product->cover = $file;
        }
        $new_product->created_by = Auth::user()->id;
        $new_product->slug = \Str::slug($new_product->name, '-');
        $new_product->save();
        $new_product->categories()->sync($request->categories);
        try{
            return response()->json([
                'success' => true,
                'message' => 'New Product Successfully Added !',
                'data' => $new_product
            ], 202);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'New Product failed Added',
                'data' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $product = new Product;
        // echo Auth::user()->id; die;
        // var_dump($product); die;
        // var_dump($request->cover); die;
        // var_dump($request->get('name')); die;
        $product->name = $request->name;
        $product->short_name = $request->short_name;
        $product->description = $request->description;
        $new_cover = $request->file('cover');
        if($new_cover){
        if($product->cover && file_exists(storage_path('app/public/' . $product->cover))){
            \Storage::delete('public/'. $product->cover);
            }
            $new_cover_path = $new_cover->store('product-covers', 'public');
            $book->cover = $new_cover_path;
        }
        $product->updated_by = Auth::user()->id;
        $product->save();
        $product->categories()->sync($request->categories);
        try{
            return response()->json([
                'success' => true,
                'message' => 'Product Successfully Updated !',
                'data' => $product
            ], 202);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Product failed Updated',
                'data' => $e->getMessage()
            ], 401);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
