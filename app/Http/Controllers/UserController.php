<?php

namespace App\Http\Controllers;

use Image;
use Validator;
use Helpers\helpers;
use App\Models\Page;
use App\Models\Post;
use App\Models\Refferal;
use App\Models\User;
use App\Models\Comment;
use App\Models\Deposit;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Reaction;
use App\Models\Withdrawal;
use App\Models\SubCategory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\CommissionLog;
use App\Models\SupportTicket;
use App\Models\GeneralSetting;
use App\Models\WithdrawMethod;
use App\Models\GatewayCurrency;
use App\Rules\FileTypeValidate;
use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Sohibd\Laravelslug\Generate;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        
        $user = Auth::user();



        $data['pageTitle'] = 'Dashboard';

        $data['posts'] = Post::where('user_id', $user->id)
                     ->where('status', '!=', 3)
                     ->latest()
                     ->limit(8)
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->get();

        $data['pending_exchange_count'] = Exchange::where('user_id', auth()->user()->id)->where('status', 0)->count();
        $data['accpted_exchange_count'] = Exchange::where('user_id', auth()->user()->id)->where('status', 1)->count();
        $data['refunded_exchange_count'] = Exchange::where('user_id', $user->id)->where('status', 3)->count();
        $data['countPost'] = Post::where('user_id', $user->id)->where('status', '!=', 3)->count();
        $data['countTicket'] = SupportTicket::where('user_id', $user->id)->count();
        $data['refferal_bonus'] = CommissionLog::where('user_id', $user->id)->sum('amount');
        $data['recent_exchanges'] = Exchange::where('user_id', $user->id)
            ->with('payment_from_getway', 'payment_to_getway')
            ->latest()
            ->take(6)
            ->get();

        return view($this->activeTemplate . 'user.dashboard', $data);
    }


    public function doexchange()
    {   
        $user = Auth::user();
        $data['pending_exchange_count'] = Exchange::where('user_id', auth()->user()->id)->where('status', 0)->count();
        $data['accpted_exchange_count'] = Exchange::where('user_id', auth()->user()->id)->where('status', 1)->count();
        $data['refunded_exchange'] = Exchange::where('user_id', auth()->user()->id)->where('status', 3)->latest()->get();
        $data['current_balance'] = User::find(auth()->user()->id);
        $data['total_transaction'] = Exchange::where('user_id', auth()->user()->id)->where('status', 2)->count();
        $data['refferal_bonus'] = CommissionLog::where('user_id', auth()->user()->id)->sum('amount');
        $data['refferal_commissions'] = CommissionLog::where('user_id', auth()->user()->id)->get();
        $data['pageTitle'] = "doexchange";
        $data['empty_message'] = "No Transaction Has Made Yet";

        $data['currencys'] = Currency::latest()->get();
        $data['currencys_sell'] = Currency::where('available_for_sell', 1)->latest()->get();
        $data['currencys_buy'] = Currency::where('available_for_buy', 1)->latest()->get();
        $data['pending_exchange'] = Exchange::with('payment_from_getway', 'user')->where('status', 0)->latest()->get();
        $data['accpted_exchange'] = Exchange::with('payment_from_getway', 'user')->where('status', 1)->latest()->get();
        $data['pageTitle'] = 'Dashboard';
        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','home')->firstOrFail();


       

        return view($this->activeTemplate . 'user.doexchange', $data);
    }
    

    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'division' => 'sometimes|required|max:50',
            'mother' => 'sometimes|required|max:50',
            'about' => 'required|max:60000',
            'image' => ['image',new FileTypeValidate(['jpg','jpeg','png'])]
            
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;
        $in['about'] = $request->about;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'mother' => $request->mother,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
            'division' => $request->division,
        ];


        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }

        if ($request->hasFile('image')) {
            $location = imagePath()['nid_front']['path'];
            $size = imagePath()['nid_front']['size'];
            $filename = uploadImage($request->nid_front, $location, $size, $user->nid_front);
            $in['nid_front'] = $filename;
        }

        if ($request->hasFile('image')) {
            $location = imagePath()['nid_back']['path'];
            $size = imagePath()['nid_back']['size'];
            $filename = uploadImage($request->nid_back, $location, $size, $user->nid_back);
            $in['nid_back'] = $filename;
        }

        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);


        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $pageTitle = 'Deposit History';
        $emptyMessage = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status',1)->get();
        $pageTitle = 'Withdraw Money';
        return view($this->activeTemplate.'user.withdraw.methods', compact('pageTitle','withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'You do not have sufficient balance for withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle','withdraw'));
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);

        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user,$request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify);
            }
        }


        if ($withdraw->amount > $user->balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['withdraw']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }

        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $pageTitle = "Withdraw History";
        $withdraws = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->orderBy('id','desc')->paginate(getPaginate());
        $data['emptyMessage'] = "No Data Found!";
        return view($this->activeTemplate.'user.withdraw.log', compact('pageTitle','withdraws'));
    }





    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Google authenticator enabled successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function postForm(){
        $pageTitle = 'Create New Post';
        $subCategories = SubCategory::where('status', 1)
                                ->latest()
                                ->whereHas('category', function($cat){
                                    $cat->where('status', 1)->whereHas('forum', function($forum){
                                        $forum->where('status', 1);
                                    });
                                })
                                ->get();
        return view($this->activeTemplate.'user.post.form', compact('pageTitle', 'subCategories'));
    }

    public function postCreate(Request $request){

        $request->validate([
            'sub_category' => 'required|exists:sub_categories,id',
            'title' => 'required|string|max:191',
            'des' => 'required|string|max:64000',
            'tags' => 'required|array|max:60000'
        ]);

        SubCategory::where('status', 1)
                   ->where('id', $request->sub_category)
                   ->whereHas('category', function($cat){
                       $cat->where('status', 1)->whereHas('forum', function($forum){
                           $forum->where('status', 1);
                       });
                   })
                ->firstOrFail();

        $general = GeneralSetting::first();
        $approve = $general->auto_approve ? 1 : 2;

        $user = Auth::user();

        $new = new Post();
        $new->user_id = $user->id;
        $new->tags = json_encode($request->tags);
        $new->sub_category_id = $request->sub_category;
        $new->post_title = $request->title;
        $slug = Generate::Slug(substr($request->title, 0, 150));
        $new->post_slug = $slug. '_' . Str::random(2);
        $new->description = $request->des;
        $new->status = $approve;
        $new->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Created post from '.$user->username;
        $adminNotification->click_url = urlPath('admin.users.post.all',$user->id);
        $adminNotification->save();

        $notify[] = ['success', 'Post created successfully.'];
        return redirect()->route('user.post.all')->withNotify($notify);
    }

    public function updatePostForm($id){

        $pageTitle = 'Update Post';
        $user = Auth::user();
       
        $post = Post::where('user_id', $user->id)
                    ->where('id', $id)
                    ->where('status', '!=', 3)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                  })->firstOrFail();

        $subCategories = SubCategory::where('status', 1)
                                    ->whereHas('category', function($cat){
                                        $cat->where('status', 1)->whereHas('forum', function($forum){
                                            $forum->where('status', 1);
                                        });
                                    })
                                ->get();

        return view($this->activeTemplate.'user.post.update', compact('pageTitle', 'subCategories', 'post'));
    }

    public function updatePost(Request $request){

        $request->validate([
            'id' => 'required|exists:posts,id',
            'sub_category' => 'required|exists:sub_categories,id',
            'title' => 'required|string|max:191',
            'des' => 'required|string|max:64000',
            'tags' => 'required|array|max:60000'
        ]);
       
        $post = Post::where('user_id', Auth::user()->id)
                    ->where('id', $request->id)
                    ->where('status', '!=', 3)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })->firstOrFail();
      $general = GeneralSetting::first();
       $approve = $general->auto_approve ? 1 : 2;
        $post->user_id = Auth::user()->id;
        $post->tags = json_encode($request->tags);
        $post->sub_category_id = $request->sub_category;
        $post->post_title = $request->title;
        $post->description = $request->des;
        $post->status = $approve;
        $post->save();

        $notify[] = ['success', 'Post updated successfully.'];
        return back()->withNotify($notify);
    }

    public function deletePost(Request $request){

        $request->validate([
            'id' => 'required|exists:posts,id',
        ]);

        $post = Post::where('id', $request->id)
                    ->where('user_id', Auth::user()->id)
                    ->where('status', '!=', 3)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->firstOrFail();

        $post->status = 3;
        $post->save();

        $notify[] = ['success', 'Post deleted successfully.'];
        return back()->withNotify($notify);
    }

    public function posts(){
        $pageTitle = 'All Posts';

        $posts = Post::where('user_id', Auth::user()->id)
                     ->where('status', '!=', 3)
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($this->activeTemplate.'user.post.index', compact('pageTitle', 'posts'));
    }

    public function reaction(Request $request){

        $validator = Validator::make($request->all(), [
            'value' => 'required|in:0,1',
            'id' => 'required|exists:posts,id'
        ]);

        if(!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $post = Post::where('id', $request->id)
                    ->where('status', 1)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->first();

        if(!$post){
            return response()->json(['success'=>false, 'message'=>'Invalid Request']);
        }

        $user = Auth::user();
        $reaction = Reaction::where('user_id', $user->id)->where('post_id', $post->id)->first();

        $userReact = $request->value;

        if($reaction){
            if($reaction->reaction == $userReact){
                $message = $userReact == 1 ? 'Already Up Voted' : 'Already Down Voted';
                return response()->json(['success'=>false, 'message'=>$message]);
            }else{
                if($userReact == 1){
                    $reaction->reaction = 1;
                    $reaction->save();

                    $post->increment('up_vote');
                    $post->decrement('down_vote');
                    $post->save();

                    return response()->json([
                        'success'=>true,
                        'message'=>'Added Up Vote Successfully',
                        'down'=>$post->down_vote,
                        'up'=>$post->up_vote
                    ]);
                }else{
                    $reaction->reaction = 0;
                    $reaction->save();

                    $post->decrement('up_vote');
                    $post->increment('down_vote');
                    $post->save();

                    return response()->json([
                        'success'=>true,
                        'message'=>'Added Down Vote Successfully',
                        'down'=>$post->down_vote,
                        'up'=>$post->up_vote
                    ]);
                }
            }
        }

        $newReact = new Reaction();
        $newReact->user_id = $user->id;
        $newReact->post_id = $post->id;
        $newReact->reaction = $userReact;
        $newReact->save();

        $react = null;

        if($newReact->reaction == 1){
            $react = 'Added Up Vote Successfully';
            $post->increment('up_vote');
            $post->save();
        }else{
            $react = 'Added Down Vote Success';
            $post->increment('down_vote');
            $post->save();
        }

        return response()->json([
            'success'=>true,
            'message'=>$react,
            'down'=>$post->down_vote,
            'up'=>$post->up_vote
        ]);
    }

    public function comment(Request $request){
      
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:60000',
            'id' => 'required|exists:posts,id'
        ]);

        if(!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $post = Post::where('id', $request->id)
                    ->where('status', 1)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->first();

        if(!$post){
            return response()->json(['success'=>false, 'message'=>'Invalid Request']);
        }

        $user = Auth::user();

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->post_id = $post->id;
        $comment->comment = $request->comment;
        $comment->save();
        $post->increment('comment');
        $post->save();
        $notify[] = ['success', 'Comment Published successfully.'];
        return back()->withNotify($notify);

    }

public function reviewForm(){
        $pageTitle = 'Give a Review';
        $subCategories = SubCategory::where('id', 7)
                                ->latest()
                                ->whereHas('category', function($cat){
                                    $cat->where('id', 7)->whereHas('forum', function($forum){
                                        $forum->where('status', 1);
                                    });
                                })
                                ->get();
        //  return $subCategories;                
        return view($this->activeTemplate.'user.review.form', compact('pageTitle', 'subCategories'));
    }

    public function reviewCreate(Request $request){

        $request->validate([
            'sub_category' => 'required|exists:sub_categories,id',
            'title' => 'required|string|max:191',
            'des' => 'required|string|max:64000',
            'tags' => 'required|array|max:60000'
        ]);

        SubCategory::where('status', 1)
                   ->where('id', $request->sub_category)
                   ->whereHas('category', function($cat){
                       $cat->where('status', 1)->whereHas('forum', function($forum){
                           $forum->where('status', 1);
                       });
                   })
                ->firstOrFail();

        $general = GeneralSetting::first();
        $approve = $general->auto_approve ? 1 : 2;

        $user = Auth::user();

        $new = new Post();
        $new->user_id = $user->id;
        $new->tags = json_encode($request->tags);
        $new->sub_category_id = $request->sub_category;
        $new->post_title = $request->title;
        $slug = Generate::Slug(substr($request->title, 0, 150));
        $new->post_slug = $slug. '_' . Str::random(3);
        $new->description = $request->des;
        $new->status = $approve;
        $new->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Created Review from '.$user->username;
        $adminNotification->click_url = urlPath('admin.users.post.all',$user->id);
        $adminNotification->save();

        $notify[] = ['success', 'Review created successfully.'];
        return redirect()->route('user.transaction.success')->withNotify($notify);
    }



   public function exchange(Request $request)
    {
        session()->forget('Track');

        $receive = Currency::find($request->receive);
        $send = Currency::find($request->send);



        if ($receive == null) {
            $notify[] = ['error', 'Select any method that we send u the money'];
            return back()->withNotify($notify);
        }

        if ($send == null) {
            $notify[] = ['error', 'Select any method that we get money'];
            return back()->withNotify($notify);
        }

        $field = json_decode($receive->user_input);

        $validate_array = [
            'send' => 'required|numeric',
            'send_amount' => 'required|numeric|gt:0',
            'receive' => 'required|numeric',
            'receive_amount' => 'required|numeric|gt:0',

        ];
        foreach ($field as $value) {
            if (strtolower($value->type) === 'email') {
                $validate_array[$value->field_name] = "sometimes|{$value->validation}|email";
                continue;
            }

            $validate_array[$value->field_name] = "sometimes|{$value->validation}";
        }

        $this->validate($request, $validate_array);


        // new Calculation for covert amount

        $percentCharge = ($request->send_amount * $send->percent_charge) / 100;

        $totalCharge = $percentCharge + $send->fixed_charge;

        $totalSendAmount = $request->send_amount - $totalCharge;

        $sendAmountConvertInBaseCurrency =  $totalSendAmount * $send->buy_at;

        $userReceiveAmount = $sendAmountConvertInBaseCurrency / $receive->sell_at;


        $reserve = $receive->reserve;
        $exchange_id = getTrx();

        if ($request->send_amount < $send->min_exchange) {
            $notify[] = ['error', 'Min exchange for this currency ' . $send->min_exchange];
            return back()->withNotify($notify);
        }

        if ($request->send_amount > $send->max_exchange) {
            $notify[] = ['error', 'Max exchange for this currency ' . $send->max_exchange];
            return back()->withNotify($notify);
        }

        if ($request->receive_amount < $receive->min_exchange) {
            $notify[] = ['error', 'Min exchange for this currency ' . $receive->min_exchange];
            return back()->withNotify($notify);
        }

        if ($request->receive_amount > $receive->max_exchange) {
            $notify[] = ['error', 'Max exchange for this currency ' . $receive->max_exchange];
            return back()->withNotify($notify);
        }

        if ($userReceiveAmount > $reserve) {
            $notify[] = ['error', 'Reserve Limit Exceed'];
            return back()->withNotify($notify);
        }

        if (Auth::check()) {

        $exchange = Exchange::create([
            'user_id' => auth()->id() ?? null,
            'payment_from' => $request->send,
            'get_amount' => $request->send_amount,
            'buy_rate' => $send->buy_at,
            'payment_to' => $request->receive,
            'send_amount' => $userReceiveAmount,
            'sell_rate' => $receive->sell_at,
            'charge' => $totalCharge,
            'exchange_id' => $exchange_id
        ]);



        session()->put('Track', $exchange->exchange_id);
    }
        return redirect()->route('user.exchange.preview');
        
    }

    public function exchangepreview()
    {

        $pageTitle = 'Exchange Checking';

        if (!session()->has('Track')) {
            return redirect()->route('home');
        }

        $data = Exchange::where('exchange_id', session('Track'))->first();

        $userSendData = Currency::findOrFail($data->payment_from);

        $userReceiveData = Currency::findOrFail($data->payment_to);

        return view($this->activeTemplate . 'user.exchange.exchangepreview', compact('pageTitle', 'userSendData', 'userReceiveData', 'data'));
    }

    public function exchangeConfirm(Request $request)
    {

        $trnx = session('Track');

        $exchange = Exchange::where('exchange_id', $trnx)->first();

        $flag = 1; //autometic payment



        $cur_sym = $exchange->payment_from_getway->cur_sym;

        try {

            $code = $exchange->payment_from_getway->gateway_currency->code;

            $availableGateway = GatewayCurrency::where('method_code', $code)->where('currency', $cur_sym)->first();
        } catch (\Throwable $th) {
            $flag = 0;
        }


        if ($exchange->payment_from_getway->payment_type_buy > 0 && $availableGateway != null && $flag == 1) {


            $validate = [];

            foreach (json_decode($exchange->payment_to_getway->user_input) as $input) {

                $inputField = str_replace(' ', '_', strtolower($input->field_name));

                if ($input->type == 'email') {
                    $validate[$inputField] = "{$input->validation}|email";
                    $exchange->email = request($inputField);
                }

                if ($input->type == 'text') {
                    $validate[$inputField] = "{$input->validation}|max:500";
                    $exchange->wallet_id = request($inputField);
                }
            }

            $this->validate($request, $validate);

            $depo['user_id'] = auth()->user()->id;
            $depo['exchange_id'] = $exchange->id;
            $depo['method_code'] = $exchange->payment_from_getway->gateway_currency->code;
            $depo['method_currency'] = strtoupper($exchange->payment_from_getway->cur_sym);
            $depo['amount'] = $exchange->get_amount;
            $depo['charge'] = $exchange->charge;
            $depo['rate'] = $exchange->buy_rate;
            $depo['final_amo'] = getAmount($exchange->get_amount);
            $depo['send_currency'] = $exchange->payment_to_getway->cur_sym;
            $depo['btc_amo'] = 0;
            $depo['btc_wallet'] = "";
            $depo['trx'] = $exchange->exchange_id;
            $depo['try'] = 0;
            $depo['status'] = 0;
            $data = Deposit::create($depo);

            $exchange->deposit_id = $data->id;
            $exchange->save();
            session()->put('Track', $data['trx']);

            return redirect()->route('user.deposit.confirm');
        }

        if ($exchange->payment_from_getway->payment_type_buy == 0 || $availableGateway == null || $flag == 0) {

            $validate = [];

            foreach (json_decode($exchange->payment_to_getway->user_input) as $input) {

                $inputField = str_replace(' ', '_', strtolower($input->field_name));

                if ($input->type == 'email') {
                    $validate[$inputField] = "{$input->validation}|email";
                    $exchange->email = request($inputField);
                }

                if ($input->type == 'text') {
                    $validate[$inputField] = "{$input->validation}|max:500";
                    $exchange->wallet_id = request($inputField);
                }
            }


            $this->validate($request, $validate);

            $exchange->save();

            return redirect()->route('user.exchange.trnx');
        }
    }

    public function transactionConfirmByTrx()
    {

        $pageTitle = 'Payment Confirmation';

        $data = session('Track');

        $exchange = Exchange::where('exchange_id', $data)->first();

        if (!$exchange) {
            $notify[] = ['error', 'Please make a new Transaction'];
            return redirect()->route('home')->withNotify($notify);
        }


        $currency = $exchange->payment_from_getway;


        return view($this->activeTemplate . 'user.exchange.transaction', compact('pageTitle', 'exchange', 'currency'));
    }

    public function transactionConfirmByTrxAdd(Request $request)
    {

        $trnx = session('Track');

        $exchange = Exchange::where('exchange_id', $trnx)->first();


        $validate = [];
        $user_proof_details = [];

        foreach (json_decode($exchange->payment_from_getway->user_proof) as $proof) {

            $inputField = str_replace(' ', '_', strtolower($proof->field_name));

            if ($proof->type == 'text') {
                $validate[$inputField] = "{$proof->validation}|max:500";
                $user_proof_details[$inputField] = request($inputField);
            }

            if ($proof->type == 'file') {
                $validate[$inputField] = "{$proof->validation}|image|mimes:jpg,png,jpeg";
                $user_proof_details[$inputField] = request($inputField);
                $image = $inputField;
            }

            if ($proof->type == 'textarea') {
                $validate[$inputField] = "{$proof->validation}|max:500";
                $user_proof_details[$inputField] = request($inputField);
            }
        }


        $this->validate($request, $validate);



        $path = imagePath()['exchange']['path'];
        $size = imagePath()['exchange']['size'];
        $data = $user_proof_details;

        if (isset($image)) {
            if ($request->hasFile($image)) {
                try {
                    $filename = uploadImage($user_proof_details[$image], $path, $size);
                    unset($user_proof_details[$image]);
                    $data = array_merge($user_proof_details, ['img_' . $image => $filename]);
                } catch (\Exception $exp) {
                    $notify[] = ['errors', 'Image could not be uploaded.'];
                    return back()->withNotify($notify);
                }
            }
        }



        $exchange->user_proof = json_encode($data);
        $exchange->save();
      
        $user = auth()->user()->fullname;
      
       $details =  $user . ' have Sent Amount '   . getAmount($exchange->get_amount) .   $exchange->payment_from_getway->cur_sym    .  ' Via ' . $exchange->payment_from_getway->name  .  ' And You Received in ' .  $exchange->payment_to_getway->name   .   ' Amount '  .   getAmount($exchange->send_amount)   .   $exchange->payment_to_getway->cur_sym ;
        
        $email= "imranbru99@gmail.com"; 
        $general = GeneralSetting::first();
        $config = $general->mail_config;
        $receiver_name = 'Dear Admin';
        $subject = 'New Exchange Request';
        $to=$request->email;
        $data = $details;
        sendGeneralEmail($email, $subject, $data, $receiver_name);

        
      

        $notify[] = ['success', 'Completed, You have completed your exchange, check your balance, we are sending your money/Dollar as soon as possible'];
        return redirect()->route('user.review.form')->withNotify($notify);
    }

    public function transactionSuccess()
    {


        $pageTitle = 'Completed Exchange';
        if (!session()->has('Track')) {
            $notify[] = ['error', 'Please make the Transaction First'];
            return redirect()->route('home')->withNotify($notify);
        }

        $exchange = Exchange::where('exchange_id', session('Track'))->first();

        session()->forget('Track');

        return view(activeTemplate() . 'user.exchange.successfull', compact('pageTitle', 'exchange'));
    }


    public function ajaxCode(Request $request)
    {
        $gateway = GatewayCurrency::where('method_code', $request->data)->first();

        if ($gateway) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['error' => 'error']);
    }



    public function exchangeDetails(Exchange $exchange)
    {
        $pageTitle = 'Exchange Details';

        return view(activeTemplate() . 'user.exchange.details', compact('pageTitle', 'exchange'));
    }

  
   public function exchangeHistory()
    {
        $pageTitle = 'Exchange History';
        $empty_message = 'No Exchange History';
        $exchanges =  Exchange::where('user_id', auth()->id())->latest()->paginate(getPaginate());

        return view(activeTemplate() . 'user.exchange.history', compact('pageTitle', 'empty_message', 'exchanges'));
    }
  
  public function pendingExchange()
    {
        $pageTitle = 'Pending Exchange';
        $empty_message = 'No Exchange Pending';
        $exchanges =  Exchange::where('user_id', auth()->id())->where('status', 0)->paginate(getPaginate());

        return view(activeTemplate() . 'user.exchange.pending', compact('pageTitle', 'empty_message', 'exchanges'));
    }
  public function approvedExchange()
    {
        $pageTitle = 'Approved Exchange';
        $empty_message = 'No Exchange Approved';
        $exchanges =  Exchange::where('user_id', auth()->id())->where('status', 1)->paginate(getPaginate());

        return view(activeTemplate() . 'user.exchange.approved', compact('pageTitle', 'empty_message', 'exchanges'));
    }

    public function refundedExchange()
    {
        $pageTitle = 'Refunded Exchange';
        $empty_message = 'No Exchange Refunded';
        $exchanges =  Exchange::where('user_id', auth()->id())->where('status', 3)->paginate(getPaginate());

        return view(activeTemplate() . 'user.exchange.refunded', compact('pageTitle', 'empty_message', 'exchanges'));
    }

    public function withdrawForm()
    {
        $pageTitle = 'Withdraw Balance';
        $currencys = Currency::where('available_for_buy', 1)->get();

        return view(activeTemplate() . 'user.withdraw.methods', compact('pageTitle', 'currencys'));
    }

    public function withdrawAjax(Request $request)
    {
        $currency = Currency::findOrFail($request->currency);

        $exchange['min'] = $currency->min_exchange * $currency->buy_at;
        $exchange['max'] = $currency->max_exchange * $currency->buy_at;
        $exchange['user_input'] = json_decode($currency->user_input);
        $exchange['status'] = $currency->payment_type_buy;
        $exchange['cur_sym'] = $currency->cur_sym;

        return $exchange;
    }

    public function withdrawAjaxInput(Request $request)
    {
        $inputValue =  $request->inputValue;

        $optionValue = Currency::findOrFail($request->option);

        $returnValue = $inputValue / $optionValue->sell_at;

        $charge = $optionValue->fixed_charge + (($returnValue * $optionValue->percent_charge) / 100);

        $returnValue -= $charge;

        return $returnValue;
    }

    public function withdrawFormSubmit(Request $request)
    {
        $request->validate([
            'currency' => 'required|numeric|exists:currencies,id',
            'send' => 'required|numeric',
            'get_amount' => 'required|numeric',
            'wallet_info' => 'required'
        ]);

        $general = GeneralSetting::first();
        $currency = Currency::findOrFail($request->currency);


        if ($request->send > auth()->user()->balance) {
            $notify[] = ['error', 'You have not enough balance'];
            return redirect()->back()->withNotify($notify);
        }
        if ($request->send < ($currency->min_exchange * $currency->buy_at)) {
            $notify[] = ['error', 'Please send At least Minimum Amount'];
            return redirect()->back()->withNotify($notify);
        }

        if ($request->get_amount > $currency->max_exchange * $currency->buy_at) {
            $notify[] = ['error', 'Maximum Amount limit Reached'];
            return redirect()->back()->withNotify($notify);
        }

        $trx = getTrx();

        $returnValue = $request->send / $currency->buy_at;

        $charge = $currency->fixed_charge + (($returnValue * $currency->percent_charge) / 100);

        $finalAmount = $returnValue -  $charge;

        $wallet = $request->wallet_info;

        $withdraw = Withdrawal::create([
            'method_id' => $currency->id,
            'user_id' => auth()->user()->id,
            'get_amount' => $request->send,
            'get_currency' => $general->cur_sym,
            'send_amount' => $returnValue,
            'send_currency' => $currency->cur_sym,
            'rate' => $currency->buy_at,
            'charge' => $charge,
            'trx' => $trx,
            'final_amount' => $finalAmount,
            'withdraw_information' => $wallet,
            'status' => 2,

        ]);

        $user = User::findOrFail($withdraw->user_id);
        $user->balance = $user->balance - $withdraw->get_amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->get_amount;
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = $charge;
        $transaction->trx_type = 'Withdraw Amount';
        $transaction->details = 'send' . getAmount($withdraw->send_amount) . ' ' . $withdraw->send_currency;
        $transaction->trx = $withdraw->trx;
        $transaction->save();


        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->send_currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->get_amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $withdraw->get_currency,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->balance),
        ]);




        session()->put('withdraw_trx', $withdraw->trx);
        $notify[] = ['success', 'You have completed your exchange, Wait for Verification and your Final Withdrawl amount'];
        return redirect()->route('user.withdraw.preview')->withNotify($notify);
    }

   

    public function refferLog()
    {
        $pageTitle = 'Refferal Commission';
        $empty_message = 'No Refferal Commission';
        $commission =  CommissionLog::where('user_id', auth()->id())->latest()->paginate(getPaginate());

        return view(activeTemplate() . 'user.affiliate.log', compact('pageTitle', 'empty_message', 'commission'));
    }
  
  
  public function transactions()
    {
        $pageTitle = 'Transactions';
        $logs = auth()->user()->transactions()->orderBy('id', 'desc')->paginate(getPaginate());
        $empty_message = 'No transaction history';
        return view(activeTemplate() . 'user.transactions', compact('pageTitle', 'logs', 'empty_message'));
    }
  
  
  public function referredUsers()
    {
        $pageTitle = "Referred Users";
        $refUsers = User::where('ref_by', auth()->user()->id)->paginate(getPaginate());
        $levels = Refferal::get();
        $user = auth()->user();
        return view(activeTemplate() . 'user.referred', compact('pageTitle', 'refUsers', 'levels', 'user'));
    }

    public function notifications()
    {
        $pageTitle = 'Notifications';
        $exchanges = Exchange::where('user_id', auth()->id())
            ->with('payment_from_getway', 'payment_to_getway')
            ->latest()
            ->paginate(getPaginate());
        $tickets = SupportTicket::where('user_id', auth()->id())->latest()->take(8)->get();
        return view($this->activeTemplate . 'user.notifications', compact('pageTitle', 'exchanges', 'tickets'));
    }

}
