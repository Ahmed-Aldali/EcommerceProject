<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $countries = Country::withCount('cities')->orderBy('id' , 'desc');



        if ($request->get('name')) {
            $countries = Country::where('name', 'like', '%' . $request->name . '%');
                                //  ->Orwhere('code', 'like', '%' . $request->code . '%');
        }
        if ($request->get('code')) {
            $countries = Country::where('code', 'like', '%' . $request->code . '%');
                                //  ->Orwhere('code', 'like', '%' . $request->code . '%');
        }
        if ($request->get('created_at')) {
            $countries = Country::where('created_at', 'like', '%' . $request->created_at . '%');
                                //  ->Orwhere('code', 'like', '%' . $request->code . '%');
        }

        $countries = $countries->paginate(5);
        // $this->authorize('viewAny',Country::class);
        return response()->view('cms.country.index' , compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('cms.country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all() , [
            'name' => 'required|string|min:3|max:20',
            'code' => 'required|numeric|digits:4'
        ] , [
            'name.required' => 'اسم الدولة مطلوب' ,
            'code.required' => 'الكود  مطلوب' ,
            'name.min' => 'يجب إدخال أكثر من 3 خانات'
        ]);


        if( ! $validator->fails()){
            $countries = new Country();

            $countries->name = $request->get('name');
            $countries->code = $request->get('code');

            $isSaved = $countries->save();
            if($isSaved){
                return response()->json(['icon' => 'success'
                 , 'title' => "Created is Successfully"] , 200);
            }
            else{
                return response()->json(['icon' => 'error'
                , 'title' => "Created is Failed"] , 400);
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
        $countries = Country::findOrFail($id);
        // $this->authorize('update',Country::class);
        return response()->view('cms.country.edit' , compact('countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator($request->all() , [
            'name' => 'required|string|min:3|max:20',
            'code' => 'required|numeric|digits:4'
        ]);

        if(! $validator->fails()){
            $countries = Country::findOrFail($id);
            $countries->name = $request->get('name');
            $countries->code = $request->get('code');

            $isUpdated = $countries->save();
            return ['redirect' => route('countries.index')];
        }
        else{
            return response()->json(['icon' => 'error' ,
                'title' => $validator->getMessageBag()->first()] , 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->authorize('delete',Country::class);
        $countries = Country::destroy($id);
    }
}