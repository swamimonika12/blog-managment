<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $page_title = 'Banners';

        return view('blog-list', [
            'page_title' => $page_title,

        ]);
    }
}
