<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;



// use Illuminate\Http\Request;



class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
        // $posts = Post::whereIn('user_id',$users)->latest()->get();
        $posts = Post::with('reacts')->withCount('reacts')->whereIn('user_id', $users)->latest()->simplePaginate(3);
        $profiles = DB::select('select * from profiles');
        return view('posts.index',compact('posts'), ['profiles'=>$profiles]);
       
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image']
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->resize(1000, 1000);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(\App\Models\Post $post)
    {
        return view("posts.show", compact('post'));
    }


    public function showPost(\App\Models\Post $post)
    {
        return view("posts.showPost", compact('post'));
    }


    public function news()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image']
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->resize(1000, 1000);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);

        return redirect('/');
    }

    public function destroy(\App\Models\Post $post){
        $delete = Post::findOrFail($post->id);
        $delete->delete();
        return redirect('/profile/' . auth()->user()->id)->with('message','Post Deleted!');
    }

    public function edit(\App\Models\Post $post){
        return view("posts.edit", compact('post'));
    }

    public function addComment(Request $request,Post $post)
    {
    $userId = auth()->user()->id;

        $post->comments()->create([
            'comment'=>$request->comment,
            'user_id'=>$userId

        ]);

        return redirect('/');
    }

    public function addShowComment(Request $request,Post $post)
    {
    $userId = auth()->user()->id;
        $post->comments()->create([
            'comment'=>$request->comment,
            'user_id'=>$userId

        ]);

        return redirect('/post/'.$post->id);
    }

    public function update(\App\Models\Post $post){
        $data = request()->validate([
            'caption' => 'required'
        ]);
        $post->update($data);
        return redirect('/post/'.$post->id);
    }

   
}
