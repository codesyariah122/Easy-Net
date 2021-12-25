<?php

namespace App\Http\Controllers\Api\Map;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use App\Models\MapCategory;
use App\Models\Map;
use Auth;

class MapController extends Controller
{
    public function __construct()
     {
        $this->middleware('auth');
        $this->middleware(function($request, $next){

        if(Gate::allows('map')) return $next($request);
           abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        // var_dump($request->all()); die;

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            // 'lat' => 'integer',
            // 'lng' => 'integer',
            'region' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $new_map = new Map;
        $new_map->title = $request->title;
        $new_map->lat=$request->lat;
        $new_map->lng=$request->lng;
        
        // $new_map->location = new Point($lat,$lng);
        // $new_map->location = new Polygon([new LineString([
        //     new Point(40.74894149554006, -73.98615270853043),
        //     new Point(40.74848633046773, -73.98648262023926),
        //     new Point(40.747925497790725, -73.9851602911949),
        //     new Point(40.74837050671544, -73.98482501506805),
        //     new Point(40.74894149554006, -73.98615270853043)
        // ])]);

        $new_map->region = $request->region;
        $new_map->external_link = $request->external_link;
        $new_map->save();
        $new_map->map_categories()->sync($request->map_categories);
        
        try{
            return response()->json([
                'success' => true,
                'message' => 'New Map Successfully Added !',
                'data' => $new_map
            ], 202);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'New Map failed Added',
                'data' => $e->getMessage()
            ], 401);
        }
    }

    public function preparePoint($point)
    {
        if (empty($point)) return NULL;
        if ($point instanceof Point) return $point;

        if (gettype($point) == "string")
        {
            if (strpos($point, 'POINT') === false) // Needs to be wrapped with POINT()
            {
                $point = "POINT(".$point.")";
            }
            return Point::fromWKT($point);
        }
        else return NULL;
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
