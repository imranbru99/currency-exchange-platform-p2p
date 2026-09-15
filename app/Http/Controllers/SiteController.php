<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Models\Forum;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Reaction;
use App\Models\Subscriber;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
 $posts = Post::whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->where('status', 1)
                     ->with(['user', 'subCategory'])
                     ->latest()
                     ->paginate(getPaginate());
        
       
        $pageTitle = 'Home';
        return view($this->activeTemplate . 'home', compact('pageTitle',  'posts'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }


  public function policy($id, $slug){
        $policy = Frontend::findOrFail($id)->data_values;

        $pageTitle = "{$policy->title}";

        return view($this->activeTemplate .'policy',compact('policy','pageTitle'));
    }


    public function contactSubmit(Request $request)
    {

        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function tutorial()
    {
        $data['pageTitle'] = "Tutorial Guide";
        return view($this->activeTemplate . 'tutorial', $data);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

   public function blogDetails($id,$slug){
        $blog = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $blog->clicks = $blog->clicks + 1;
        $blog->save();

        $blogs = Frontend::where('data_keys', 'blog.element')->latest()->take(5)->get();

      
        $pageTitle = "Blog Details";
        return view($this->activeTemplate . 'blogDetails', compact('blog', 'pageTitle', 'blogs'));
    }



    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        $notify[] = ['success','Cookie accepted successfully'];
        return back()->withNotify($notify);
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function policyPage($page, $id){
        $pageContent = Frontend::where('id',$id)->where('data_keys','policy_pages.element')->firstOrFail();
        $pageTitle = ucfirst($page);
        return view($this->activeTemplate.'policy_page',compact('pageContent','pageTitle'));
    }

    public function adRedirect($hash){

        $id = decrypt($hash);
        $ad = Advertisement::findOrFail($id);
        $ad->increment('click');
        $ad->save();

        return redirect($ad->url);
    }

    public function categoryPosts($slug, $id){

        $category = Category::where('id', $id)
                            ->where('status', 1)
                            ->whereHas('forum', function($q){
                                $q->where('status', 1);
                            })->firstOrFail();

        $subCats = $category->subCategory()->where('status', 1)->get(['id']);

        $posts = Post::where('status', 1)
                     ->whereIn('sub_category_id', $subCats)
                     ->with(['user', 'subCategory.category'])
                     ->latest()
                     ->paginate(getPaginate());

        $pageTitle = 'All Posts of '.$category->name;
        return view($this->activeTemplate.'post',compact('pageTitle','posts'));
    }

    public function postDetails($slug, $id){

        $post = Post::where('id', $id)
                    ->with(['user'])
                    ->where('status', 1)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->firstOrFail();

        $post->increment('view');
        $post->save();

        $pageTitle = $post->post_title;
        $user = Auth::user();

        $comments = Comment::where('post_id', $post->id)->with('user')->latest()->take(5)->get();

        return view($this->activeTemplate.'post_details',compact('pageTitle', 'post', 'user', 'comments'));
    }
  
   public function loveDetails($slug){

        $post = Post::where('post_slug', $slug) 
           ->with(['user'])
                    ->where('status', 1)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                     ->first();

        $post->increment('view');
        $post->save();

        $pageTitle = $post->post_title;
        $user = Auth::user();

        $comments = Comment::where('post_id', $post->id)->with('user')->latest()->take(5)->get();

        return view($this->activeTemplate.'post_details',compact('pageTitle', 'post', 'user', 'comments'));
    }

    public function moreComment(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:comments,id',
            'postId' => 'required|exists:posts,id'
        ]);

        if(!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $post = Post::where('id', $request->postId)->firstOrFail();

        if(!$post){
            return response()->json(['success'=>false, 'message'=>'Invalid Request']);
        }

        $id = $request->id - 4;

        $comments = Comment::where('id', '<', $id)
                               ->where('post_id', $request->postId)
                               ->with('user')
                               ->latest()
                               ->take(5)
                               ->get();

        $nextComment = Comment::where('id','<',@$comments[0]->id??1)->where('post_id', $request->postId)->first();

        if($nextComment){
            $msg = 200;
        }else{
            $msg = 400;
        }

        return response()->json(['success'=>true, 'array'=>$comments,'message'=>$msg]);
    }

    public function search(Request $request){

        $input = $request->title;

        if(!$input){
            $notify[] = ['error','Please Enter Post Title'];
            return back()->withNotify($notify);
        }

        $posts = Post::where('post_title', 'LIKE', '%' . $input . '%')
                     ->whereHas('subCategory', function($subCat){
                         $subCat->where('status', 1)->whereHas('category', function($cat){
                             $cat->where('status', 1)->whereHas('forum', function($forum){
                                 $forum->where('status', 1);
                             });
                         });
                     })
                     ->where('status', 1)
                     ->with(['user', 'subCategory'])
                     ->latest()
                     ->paginate(getPaginate());

        $pageTitle = $input;
        return view($this->activeTemplate.'post',compact('pageTitle','posts'));
    }

    public function allPost(){
        $posts = Post::whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->where('status', 1)
                     ->with(['user', 'subCategory'])
                     ->latest()
                     ->paginate(getPaginate());

        $pageTitle = 'All Posts';
        return view($this->activeTemplate.'post',compact('pageTitle','posts'));
    }

    public function forum($slub, $id){
        $forum = Forum::where('status', 1)->where('id', $id)->firstOrFail();
        $pageTitle = $forum->name;
        return view($this->activeTemplate.'forum',compact('pageTitle','forum'));
    }

    public function subCategoryPosts($slug, $id){

        $subCategory = SubCategory::where('id', $id)
                            ->where('status', 1)
                            ->whereHas('category', function($cat){
                                $cat->where('status', 1)->whereHas('forum', function($forum){
                                    $forum->where('status', 1);
                                });
                            })->select('id', 'name')->firstOrFail();

        $posts = Post::where('status', 1)
                     ->where('sub_category_id', $subCategory->id)
                     ->with(['user', 'subCategory.category'])
                     ->latest()
                     ->paginate(getPaginate());

        $pageTitle = 'All Posts of '.$subCategory->name;
        return view($this->activeTemplate.'post',compact('pageTitle','posts'));
    }

    public function user($slug){
        $user = User::where('slug', $slug)->firstOrFail();
        $exchange= Exchange::where('user_id', $user->id)->count();
        $transaction= Transaction::where('user_id', $user->id)->count();
        $completed = Exchange::where('user_id', $user->id)->where('status', 1)->count();
        $pending = Exchange::where('user_id', $user->id)->where('status', 0)->count();
        $trustScore = $exchange > 0 ? (int) round(($completed / $exchange) * 100) : 0;
        $pageTitle = $user->fullname;
        return view($this->activeTemplate.'profile',compact('pageTitle','user', 'exchange', 'transaction', 'completed', 'pending', 'trustScore'));
    }

    public function userTopics($slug, $id){

        $user = User::findOrFail($id);
        $pageTitle = 'Topics of '.$user->fullname;

        $posts = Post::where('user_id', $id)
                     ->where('status', 1)
                     ->with('subCategory')
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($this->activeTemplate.'profile_post',compact('pageTitle','user', 'posts'));
    }

    public function userAnswer($slug, $id){

        $user = User::findOrFail($id);
        $pageTitle = 'Answered '.$user->fullname;

        $comments = Comment::where('user_id', $id)->get('post_id')->toArray();

        $posts = Post::where('status', 1)
                     ->whereIn('id', $comments)
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($this->activeTemplate.'profile_post',compact('pageTitle','user', 'posts'));
    }

    public function userUpVote($slug, $id){

        $user = User::findOrFail($id);
        $pageTitle = 'Up Vote '.$user->fullname;

        $upVotes = Reaction::where('user_id', $id)->where('reaction', 1)->get('post_id');

        $posts = Post::where('status', 1)
                     ->whereIn('id', $upVotes)
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($this->activeTemplate.'profile_post',compact('pageTitle','user', 'posts'));
    }

    public function userDownVote($slug, $id){

        $user = User::findOrFail($id);
        $pageTitle = 'Down Vote '.$user->fullname;

        $downVotes = Reaction::where('user_id', $id)->where('reaction', 0)->get('post_id');

        $posts = Post::where('status', 1)
                     ->whereIn('id', $downVotes)
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($this->activeTemplate.'profile_post',compact('pageTitle','user', 'posts'));
    }


  
    public function tryexchange()
    {
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }
        $data['currencys'] = Currency::latest()->get();
        $data['currencys_sell'] = Currency::where('available_for_sell', 1)->latest()->get();
        $data['currencys_buy'] = Currency::where('available_for_buy', 1)->latest()->get();
        $data['pending_exchange'] = Exchange::with('payment_from_getway', 'user')->where('status', 0)->latest()->get();
        $data['accpted_exchange'] = Exchange::with('payment_from_getway', 'user')->take(10)->where('status', 1)->latest()->get();
        $data['pageTitle'] = 'Exchange';
        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','home')->firstOrFail();
       
        return view($this->activeTemplate . 'hexchange', $data);
    }
  
    public function exchangeHistory()
    {
        $pageTitle = "Contact Us";
        $exchanges = Exchange::latest()->with('payment_to_getway', 'user', 'payment_from_getway')->where('status', 1)->get();
        return view($this->activeTemplate . 'exchange',compact('pageTitle', 'exchanges'));
    }

    public function exchangeDetail($exchange)
    {
        $pageTitle = "Exchange Details";
        $exchanges = Exchange::where('exchange_id', $exchange)->with('payment_to_getway', 'user', 'payment_from_getway')->first();
        return view($this->activeTemplate . 'exchangedetail',compact('pageTitle', 'exchanges'));
    }

    public function rates()
    {
        $currencies = Currency::where(function ($query) {
                $query->where('available_for_sell', 1)->orWhere('available_for_buy', 1);
            })
            ->latest()
            ->get();
        $pageTitle = 'Live Rates & Fees';
        return view($this->activeTemplate . 'rates', compact('pageTitle', 'currencies'));
    }

    public function howItWorks()
    {
        $pageTitle = 'How It Works';
        $stats = [
            'completed' => Exchange::where('status', 1)->count(),
            'pending' => Exchange::where('status', 0)->count(),
        ];
        return view($this->activeTemplate . 'how', compact('pageTitle', 'stats'));
    }

    public function platformStatus()
    {
        $pageTitle = 'Platform Status & Reserves';
        $stats = [
            'completed' => Exchange::where('status', 1)->count(),
            'pending' => Exchange::where('status', 0)->count(),
            'refunded' => Exchange::where('status', 3)->count(),
            'members' => User::count(),
            'today' => Exchange::where('status', 1)->whereDate('updated_at', Carbon::today())->count(),
            'methods' => Currency::where(function ($query) {
                $query->where('available_for_sell', 1)->orWhere('available_for_buy', 1);
            })->count(),
        ];
        $currencies = Currency::where(function ($query) {
                $query->where('available_for_sell', 1)->orWhere('available_for_buy', 1);
            })
            ->latest()
            ->get();
        $recent = Exchange::with('payment_from_getway', 'payment_to_getway', 'user')
            ->where('status', 1)
            ->latest()
            ->take(12)
            ->get();

        return view($this->activeTemplate . 'status', compact('pageTitle', 'stats', 'currencies', 'recent'));
    }

    public function trackExchange(Request $request)
    {
        $pageTitle = 'Track Exchange';
        $exchange = null;
        $searched = $request->filled('exchange_id');

        if ($searched) {
            $exchange = Exchange::where('exchange_id', trim($request->exchange_id))
                ->with('payment_from_getway', 'payment_to_getway', 'user')
                ->first();
        }

        return view($this->activeTemplate . 'track', compact('pageTitle', 'exchange', 'searched'));
    }

    public function faq()
    {
        $faq = getContent('faq.content', true);
        $faqs = getContent('faq.element');
        $pageTitle = 'Frequently Asked Questions';
        return view($this->activeTemplate . 'faq', compact('pageTitle', 'faq', 'faqs'));
    }

    public function blogs()
    {
        $blogSearch = Frontend::where('data_keys', 'blog.element')->latest()->paginate(getPaginate());
        $pageTitle = 'News & Blog';
        return view($this->activeTemplate . 'searchblog', compact('pageTitle', 'blogSearch'));
    }

    public function blogSearch(Request $request)
    {
        $search = $request->search ?? $request->title;
        $blogSearch = Frontend::where('data_keys', 'blog.element')
            ->when($search, function ($query) use ($search) {
                $query->where('data_values', 'LIKE', '%' . $search . '%');
            })
            ->latest()
            ->paginate(getPaginate());
        $pageTitle = $search ? 'Blog Search: ' . $search : 'News & Blog';
        return view($this->activeTemplate . 'searchblog', compact('pageTitle', 'blogSearch'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:191',
        ]);

        $exists = Subscriber::where('email', $request->email)->first();
        if ($exists) {
            $notify[] = ['error', 'You are already subscribed to our newsletter'];
            return back()->withNotify($notify);
        }

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        $notify[] = ['success', 'Thanks for subscribing. You will receive rate and offer updates.'];
        return back()->withNotify($notify);
    }

    public function loadMore()
    {
        $posts = Post::where('status', 1)
            ->whereHas('subCategory', function ($subCat) {
                $subCat->where('status', 1)->whereHas('category', function ($cat) {
                    $cat->where('status', 1)->whereHas('forum', function ($forum) {
                        $forum->where('status', 1);
                    });
                });
            })
            ->with(['user', 'subCategory'])
            ->latest()
            ->paginate(getPaginate());

        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

}
