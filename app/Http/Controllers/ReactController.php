<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;

class ReactController extends Controller
{

    public function store(Post $post, User $user)
    {
        $react = $post->reacts()->where('user_id', $user->id)->first();
        if ($react) {
            $react->delete();
            return "unlike";
        } else {
            $post->reacts()->create([
                'user_id' => $user->id
            ]);
            return "like";
        }
    }
}
