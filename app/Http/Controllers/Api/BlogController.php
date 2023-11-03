<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class BlogController extends Controller
{
    public function index() {
        $user = Auth::user();
        $blogs = Blog::Like($user)->get();
        
        return response()->json([
            'data' => $blogs,
            'message' => "Blog List Returned Succesfully",
            'status' => '1',
        ]);

    }
    public function create(StoreBlogRequest $request) {
        $user = Auth::user();
        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'data' => $blog,
            'message' => "Blog Created Succesfully",
            'status' => '1',
        ]);
    }
    public function like(Blog $blog, Request $requet) {
        $user = Auth::user();
        $is_liked = $blog->likes()->where('likable_id',$blog->id)->where('user_id',$user->id)->first();
        if ($is_liked) {
            $blog->likes()->where('likable_id',$blog->id)->where('user_id',$user->id)->delete();

            return response()->json([
                'message' => "Blog Disliked Succesfully",
                'status' => '1',
            ]);
        } else {
            $liked_blog = $blog->likes()->create([
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => "Blog Liked Succesfully",
                'status' => '1',
            ]);
        }  
    }
}
