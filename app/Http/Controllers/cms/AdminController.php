<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::orderBy('id' , 'desc')->paginate(10);
        // $this->authorize('viewAny',Admin::class);
        return response()->view('cms.admin.index' , compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        // $roles = Role::where('guard_name' , 'admin')->get();
        // $this->authorize('create',Admin::class);
        return response()->view('cms.admin.create' , compact('cities' ));
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
            $admins = new Admin();
            $admins->email = $request->input('email');
            $admins->password = Hash::make($request->input('password'));

            $isSaved = $admins->save();

            if($isSaved){
                $users = new User();

                // $roles = Role::findOrFail($request->get('role_id'));
                // $admins->assignRole($roles->name);

                if (request()->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . 'image.' . $image->getClientOriginalExtension();
                    $image->move('storage/images/admin', $imageName);
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
                $users->actor()->associate($admins);

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
        $admins = Admin::findOrFail($id);
        // $this->authorize('update',Admin::class);
        return response()->view('cms.admin.edit' , compact('cities' , 'admins'));
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
            $admins = Admin::findOrFail($id);
            $admins->email = $request->input('email');
            // $admins->password = Hash::make($request->input('password'));

            $isUpdate = $admins->save();

            if($isUpdate){
                $users = $admins->user;

                if (request()->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . 'image.' . $image->getClientOriginalExtension();
                    $image->move('storage/images/admin', $imageName);
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
                $users->actor()->associate($admins);

                $isUpdate = $users->save();

                return ['redirect' => route('admins.index')];

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
        // $this->authorize('delete',Admin::class);
        $admins = Admin::destroy($id);
    }
} 