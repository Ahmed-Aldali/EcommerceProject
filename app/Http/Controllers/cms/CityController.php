<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cities = City::withCount('country')->OrderBy('id' , 'desc');

        if ($request->get('name')) {
            $cities = City::where('name', 'like', '%' . $request->name . '%');
                                //  ->Orwhere('code', 'like', '%' . $request->code . '%');
        }
        if ($request->get('street')) {
            $cities = City::where('street', 'like', '%' . $request->street . '%');
                                //  ->Orwhere('code', 'like', '%' . $request->code . '%');
        }
        if ($request->get('created_at')) {
            $cities = City::where('created_at', 'like', '%' . $request->created_at . '%');
                                //  ->Orwhere('code', 'like', '%' . $request->code . '%');
        }

        $cities = $cities->paginate(5);
        
        // $this->authorize('viewAny',City::class);
        return response()->view('cms.city.index' , compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        // $this->authorize('create',City::class);
        return response()->view('cms.city.create' , compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all() , [
            'name' => 'required' ,
            'street' => 'required' ,
            'country_id' => 'required'
        ] , [

        ]);

        if ( ! $validator->fails()){
            $cities = new City();
            $cities->name = $request->input('name');
            $cities->street = $request->input('street');
            $cities->country_id = $request->input('country_id');

            $isSaved = $cities->save();

            if ($isSaved){
                return  response()->json([
                    'icon' => 'success' ,
                    'title' => 'Created is Successfully'
                ] , 200);
            }

            else {
                return  response()->json([
                    'icon' => 'error' ,
                    'title' => 'Created is Failed'
                ] , 400);
            }

        }
        else{
            return response()->json([
                'icon' => 'error' ,
                'title' => $validator->getMessageBag()->first()
            ] , 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cities = City::findOrFail($id);
        $countries = Country::all();
        // $this->authorize('update',City::class);
        return response()->view('cms.city.edit' , compact('cities' , 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator($request->all() , [
            'name' => 'required' ,
            'street' => 'required' ,
            'country_id' => 'required'
        ] , [

        ]);

        if ( ! $validator->fails()){
            $cities = City::findOrFail($id);
            $cities->name = $request->input('name');
            $cities->street = $request->input('street');
            $cities->country_id = $request->input('country_id');

            $isUpdate = $cities->save();

            return ['redirect' => route('cities.index')];
        }
        else {
            return response()->json([
                'icon' => 'error' ,
                'title' => $validator->getMessageBag()->first()
            ] , 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->authorize('delete',City::class);
        $cities = City::destroy($id);
    }
}