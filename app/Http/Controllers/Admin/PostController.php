<?php

namespace App\Http\Controllers\Admin;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostController extends Controller
{


	public function pending(){
		$pageTitle = 'Pending Posts';

		$posts = Post::where('status', 2)
                    ->latest()
                    ->with('user')
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->paginate(getPaginate());

		return view('admin.post.index', compact('pageTitle', 'posts'));
	}

	public function approved(){
		$pageTitle = 'Approved Topics';

		$posts = Post::where('status', 1)
                    ->latest()
                    ->with('user')
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->paginate(getPaginate());

		return view('admin.post.index', compact('pageTitle', 'posts'));
	}

	public function posts(){
		$pageTitle = 'All Topics';

		$posts = Post::where('status', '!=', 3)
                    ->latest()
                    ->with('user')
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->paginate(getPaginate());

		return view('admin.post.index', compact('pageTitle', 'posts'));
	}

	public function approve(Request $request){

		$request->validate([
			'id' => 'required|exists:posts,id',
		]);

		$post = Post::where('id', $request->id)
                    ->where('status', 2)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->firstOrFail();
		$post->status = 1;
		$post->save();

		$notify[] = ['success', 'Post approved successfully.'];
        return back()->withNotify($notify);
	}

	public function details($id){

		$post = Post::where('id', $id)->where('status', '!=', 3)->firstOrFail();
		$pageTitle = 'Posts Details of '.$post->post_title;
		return view('admin.post.details', compact('pageTitle', 'post'));
	}


  
      public function reject(Request $request)
    {

      
        $post = Post::where('id', $request->id)
                    ->where('status', 2)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->firstOrFail();
		$post->delete();
         $notify[] = ['success', 'Forum Post Deleted successfully.'];
        return back()->withNotify($notify);

    }
    public function indexComment()
    {

      
        $post = Comment::latest()
                ->get();
        
        // return $post;
		$pageTitle = 'All Comments';
		return view('admin.post.comment', compact('pageTitle', 'post'));

    }

    public function delete(Request $request)
    {  
        $post = Comment::where('id', $request->id);
		$post->delete();
         $notify[] = ['success', 'Forum Post Deleted successfully.'];
        return back()->withNotify($notify);

    }

}
