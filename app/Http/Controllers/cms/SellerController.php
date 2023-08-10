<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = Seller::orderBy('id' , 'desc')->paginate(10);
        return response()->view('cms.seller.index' , compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        return response()->view('cms.seller.create' , compact('cities' ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all() , [
            'first_name' => 'required' ,
            'last_name' => 'required' ,
            'email' => 'required|email' ,
            'password' => 'required' ,
            'mobile' => 'required' ,
            'gender' => 'required' ,
            'status' => 'required' ,
            'date' => 'required' ,
            'image'=>"image|max:2048|mimes:png,jpg,jpeg,pdf",


        ] ,[

        ]);

        if(! $validator->fails()){
            $sellers = new Seller();
            $sellers->email = $request->input('email');
            $sellers->password = Hash::make($request->input('password'));

            $isSaved = $sellers->save();

            if($isSaved){
                $users = new User();

                // $roles = Role::findOrFail($request->get('role_id'));
                // $admins->assignRole($roles->name);

                if (request()->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . 'image.' . $image->getClientOriginalExtension();
                    $image->move('storage/images/seller', $imageName);
                    $users->image = $imageName;
                    }
                    
                $users->first_name = $request->input('first_name');
                $users->last_name = $request->input('last_name');
                $users->gender = $request->input('gender');
                $users->mobile = $request->input('mobile');
                $users->status = $request->input('status');
                $users->date = $request->input('date');
                $users->address = $request->input('address');
                $users->city_id = $request->input('city_id');
                $users->actor()->associate($sellers);

                $isSaved = $users->save();

                return response()->json([
                    'icon' => 'success' ,
                    'title' => 'Created is Successfully'

                ] , 200);


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
        $cities= City::all();
        $sellers = Seller::findOrFail($id);
        return response()->view('cms.seller.edit' , compact('cities' , 'sellers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $validator = Validator($request->all() , [
            'first_name' => 'required' ,
            'last_name' => 'required' ,
            'email' => 'required|email' ,
            'password' => 'nullable' ,
            'mobile' => 'required' ,
            'gender' => 'required' ,
            'status' => 'required' ,
            'date' => 'required' ,

        ] ,[

        ]);

        if(! $validator->fails()){
            $sellers = Seller::findOrFail($id);
            $sellers->email = $request->input('email');

            $isUpdate = $sellers->save();

            if($isUpdate){
                $users = $sellers->user;

                if (request()->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . 'image.' . $image->getClientOriginalExtension();
                    $image->move('storage/images/seller', $imageName);
                    $users->image = $imageName;
                    }

                $users->first_name = $request->input('first_name');
                $users->last_name = $request->input('last_name');
                $users->gender = $request->input('gender');
                $users->mobile = $request->input('mobile');
                $users->status = $request->input('status');
                $users->date = $request->input('date');
                $users->address = $request->input('address');
                $users->city_id = $request->input('city_id');
                $users->actor()->associate($sellers);

                $isUpdate = $users->save();

                return ['redirect' => route('sellers.index')];

                // return response()->json([
                //     'icon' => 'success' ,
                //     'title' => 'Updated is Successfully'

                // ] , 200);


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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sellers = Seller::destroy($id);
    }
}