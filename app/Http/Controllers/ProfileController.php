<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($id)
    {
        $profile = Profile::where('user_id' ,$id)->firstOrFail();
        return response()->json([$profile , 200]);
    }
    public function store(StoreProfileRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $profile = Profile::create($validatedData);
        return response()->json([
            'message' => 'Profile Created Successfully',
            'profile' => $profile,
        ],201);
    }

    public function update(UpdateProfileRequest $request, $id)
    {
        $profileu = Profile::findOrFail($id);
        $profileu->update($request->validated());
        return response()->json($profileu, 201);
    }
}
