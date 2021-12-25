<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Category;

class CategoryController extends Controller
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

           if(Gate::allows('category-product')) return $next($request);
           abort(403, 'Anda tidak memiliki cukup hak akses');
       });
    }

    public function index(Request $request)
    {
         $user =  $request->user();

        // echo Auth::user()->login; die;

        if($user['login'] == Auth::user()->login){      
            $category = Category::all();
            try{
                return response()->json([
                    'success' => true,
                    'message' => 'Fetch category data',
                    'data' => $category
                ]);
            }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Error do not access this data'
        ]);
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
        $category = new Category;
        $category->name = strtolower($request->name);
        $category->created_by =  Auth::user()->id;
        $category->save();
        try{
            return response()->json([
                'success' => true,
                'message' => 'Success add new category',
                'data' => $category 
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed add new category : '.$e->getMessage()
            ]);
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
