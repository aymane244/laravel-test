<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(User $user){
        $users = User::all();
        $id = auth()->user()->id;
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id): false;
        return view("contacts.index", compact('users', 'follows', 'id'));
    }
}
