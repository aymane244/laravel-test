<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
//use Intervention\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        //dd($user); dd() to output in navigator
       // $user = User::all();
        $id = auth()->user()->id;
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id): false;
        return view('profiles.index', compact('user', 'follows', 'id'));
    }
    public function edit(User $user){
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }
    public function update(User $user){
        $this->authorize('update', $user->profile);
        $data = request()->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'required',
            'image'=>'',
        ]);
        //dd($data);
        $id = $user->id;
        auth()->user()->profile->update($data);
        if(request('image')){
            $imagePath = request('image')->store('profile', 'public');
            //$image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);
            //$image->save();
            auth()->user()->profile->update(array_merge(
                $data,
                ['image'=>$imagePath],
            ));
        }
        return redirect("profile/$id");
    }
}