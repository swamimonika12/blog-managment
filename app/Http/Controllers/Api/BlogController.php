<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest; 
use App\Models\Blog;
use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $blogs = Blog::withCount(['likers']);
        if($request->most_liked == 1) {
            $blogs = $blogs->mostLikedFirst()->latest();
        }
        return response()->json([
            'data' => $blogs->get(),
            'message' => "Blog List Returned Successfully",
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
            'message' => "Blog Created Successfully",
            'status' => '1',
        ]);
    }

    public function like(Blog $blog, Request $request) {
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
