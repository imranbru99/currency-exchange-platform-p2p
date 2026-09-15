<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Exchange;
use App\Models\Withdrawal;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Page;
use App\Models\Post;
use App\Models\Comment;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Forum;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app['request']->server->set('HTTPS', false);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       

        $activeTemplate = activeTemplate();
        $general = GeneralSetting::first();
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['pages'] = Page::where('tempname',$activeTemplate)->where('slug','!=','home')->get();
        view()->share($viewShare);


        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'banned_users_count'           => User::banned()->count(),
                'email_unverified_users_count' => User::emailUnverified()->count(),
                'sms_unverified_users_count'   => User::smsUnverified()->count(),
                'pending_ticket_count'         => SupportTicket::whereIN('status', [0,2])->count(),
                'pending_post'    => Post::where('status', 2)->count(),
                'pending_Comment'    => Comment::count(),

                
                'pending_deposits_count'    => Deposit::pending()->count(),
                'pending_withdraw_count'    => Withdrawal::pending()->count(),
                'pending_exchange'             => Exchange::where('status', 0)->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'=>AdminNotification::where('read_status',0)->with('user')->orderBy('id','desc')->get(),
            ]);
        });

        view()->composer($activeTemplate.'partials.left_bar', function ($view) {
            $view->with([
                'forums' => Forum::where('status', 1)->latest()->get(),

                'categories' => Category::where('status', 1)
                                        ->latest()
                                        ->with('subCategory')
                                        ->whereHas('forum', function($forum){
                                            $forum->where('status', 1);
                                        })
                                        ->get(),

                'disscussions' => Post::where('status', 1)
                                      ->orderBy('comment', 'DESC')
                                      ->limit(10)
                                      ->whereHas('subCategory', function($subCat){
                                          $subCat->where('status', 1)->whereHas('category', function($cat){
                                              $cat->where('status', 1)->whereHas('forum', function($forum){
                                                  $forum->where('status', 1);
                                              });
                                          });
                                      })
                                      ->get(),
            ]);
        });

        view()->composer($activeTemplate.'partials.right_bar', function ($view) {
            $view->with([
                'forum' => Forum::where('status', 1)->count(),
                'post' => Post::where('status', 1)
                              ->whereHas('subCategory', function($subCat){
                                  $subCat->where('status', 1)->whereHas('category', function($cat){
                                      $cat->where('status', 1)->whereHas('forum', function($forum){
                                          $forum->where('status', 1);
                                      });
                                  });
                              })
                              ->count(),

                'category' => Category::where('status', 1)
                                      ->whereHas('forum', function($forum){
                                          $forum->where('status', 1);
                                      })
                                      ->count(),

                'subCategory' => SubCategory::where('status', 1)
                                            ->whereHas('category', function($cat){
                                                $cat->where('status', 1)->whereHas('forum', function($forum){
                                                    $forum->where('status', 1);
                                                });
                                            })
                                            ->count(),

                'unTalks' => Post::where('status', 1)
                                 ->where('comment',  0)
                                 ->with('user')
                                 ->latest()
                                 ->limit(10)
                                 ->whereHas('subCategory', function($subCat){
                                     $subCat->where('status', 1)->whereHas('category', function($cat){
                                         $cat->where('status', 1)->whereHas('forum', function($forum){
                                             $forum->where('status', 1);
                                         });
                                     });
                                 })
                                 ->get(),

                'topContributors' => Comment::selectRaw('user_id, count(*) as total')
                                            ->with('user')
                                            ->groupBy('user_id')
                                            ->orderBy('total', 'DESC')
                                            ->limit(10)
                                            ->get(),

                'hots' => Comment::selectRaw('post_id, count(*) as total')
                                            ->whereDate('created_at', '>', Carbon::now()->subDays(3))
                                            ->with(['post.user'])
                                            ->groupBy('post_id')
                                            ->orderBy('total', 'DESC')
                                            ->limit(10)
                                            ->whereHas('post', function($post){
                                                $post->where('status', 1)->whereHas('subCategory', function($subCat){
                                                    $subCat->where('status', 1)->whereHas('category', function($cat){
                                                        $cat->where('status', 1)->whereHas('forum', function($forum){
                                                            $forum->where('status', 1);
                                                        });
                                                    });
                                                });
                                            })
                                            ->get(),

            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

      if (app()->environment('remote')) {
            URL::forceScheme('https');
        }


        Paginator::useBootstrap();

    }
}
