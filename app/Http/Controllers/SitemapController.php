<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Exchange;
use App\Models\User;

use Illuminate\Http\Request;

class SitemapController extends Controller
{

    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $users = User::where('status', 1)->latest()->get();
         $post = Post::whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->where('status', 1)
                     ->with(['user', 'subCategory'])
                     ->latest()->get();

        return response()->view(activeTemplate(). 'sitemap.xml', [
            'posts' => $post,
           'users' => $users,
        ])->header('Content-Type', 'text/xml');
    }
  
      public function exchange()
    {
        $exchange = Exchange::where('status', 1)->latest()->get();
        return response()->view(activeTemplate(). 'sitemap.exchange', [
            'exchanges' => $exchange,
        ])->header('Content-Type', 'text/xml');
    }
}
