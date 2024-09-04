<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UpdateUserController extends Controller
{
    public function updateUser(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'contact_no' => 'required|string|max:20',
            'profile_picture' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Handle image upload
        if ($request->hasFile('profile_picture')) {
            // Delete the old image if it exists
            if ($user->profile_image) {
                Storage::delete($user->profile_picture);
            }

            // Store the new image
            $path = $request->file('profile_picture')->store('profile_picture');
            $user->profile_picture = $path;
        }
        

        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->contact_no = $request->input('contact_no');
        $user->profile_picture = $request->input('profile_picture');
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    // public function updateUser(Request $request)
    // {
    //     // Validate the request
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
    //         'contact_no' => 'required|string|max:20',
    //         'profile_picture' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // Get the authenticated user
    //     $user = Auth::user();

    //     // Handle image upload
    //     $validatedData = $validator->validated();

    //     if ($request->has('profile_picture')) {
    //         $profilePicBase64 = $request->input('profile_picture');
    //         $profilePic = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $profilePicBase64));
    //         $profilePicFilename = time() . rand(10000, 99999) . '.png'; // Assuming the file is a PNG image
    //         $profilePicPath = 'profile_pictures/' . $profilePicFilename;
    //         Storage::disk('public')->put($profilePicPath, $profilePic);
    //         $validatedData['profile_picture'] = 'storage/' . $profilePicPath;

    //         // Delete the old image if it exists
    //         if ($user->profile_picture) {
    //             Storage::disk('public')->delete(str_replace('storage/', '', $user->profile_picture));
    //         }

    //         $user->profile_picture = $validatedData['profile_picture'];
    //     }

    //     // Update user details
    //     $user->name = $validatedData['name'];
    //     $user->email = $validatedData['email'];
    //     $user->contact_no = $validatedData['contact_no'];
    //     $user->save();

    //     return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    // }

}
