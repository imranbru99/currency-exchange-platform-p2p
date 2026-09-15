<?php

use Illuminate\Support\Facades\Route;
Route::get('post/search', 'SiteController@search')->name('search');
Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap.index');
Route::get('/exchange.xml', 'SitemapController@exchange')->name('exchange.index');
Route::get('/exchange/History', 'SiteController@exchangeHistory')->name('exchangeHistory');
Route::get('/exchange/{exchange}', 'SiteController@exchangeDetail')->name('exchangeDetail');
Route::get('/try/exchange', 'SiteController@tryexchange')->name('tryexchange');
Route::get('/rates', 'SiteController@rates')->name('rates');
Route::get('/track-exchange', 'SiteController@trackExchange')->name('track.exchange');
Route::get('/how-it-works', 'SiteController@howItWorks')->name('how');
Route::get('/status', 'SiteController@platformStatus')->name('status');
Route::get('/faq', 'SiteController@faq')->name('faq');
Route::get('/blog', 'SiteController@blogs')->name('blog');
Route::get('/blog/search', 'SiteController@blogSearch')->name('blog.search');
Route::get('/tutorial', 'SiteController@tutorial')->name('tutorial');
Route::post('/contact', 'SiteController@contactSubmit')->name('contact.send');
Route::get('policy/{id}/{slug}','SiteController@policy')->name('policy');
Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholder.image');

Route::namespace('Gateway')->prefix('ipn')->name('ipn.')->group(function () {
    Route::post('paypal', 'paypal\ProcessController@ipn')->name('paypal');
    Route::get('paypal_sdk', 'paypal_sdk\ProcessController@ipn')->name('paypal_sdk');
    Route::post('perfect_money', 'perfect_money\ProcessController@ipn')->name('perfect_money');
    Route::post('stripe', 'stripe\ProcessController@ipn')->name('stripe');
    Route::post('stripe_js', 'stripe_js\ProcessController@ipn')->name('stripe_js');
    Route::post('stripe_v3', 'stripe_v3\ProcessController@ipn')->name('stripe_v3');
    Route::post('skrill', 'skrill\ProcessController@ipn')->name('skrill');
    Route::post('paytm', 'paytm\ProcessController@ipn')->name('paytm');
    Route::post('payeer', 'payeer\ProcessController@ipn')->name('payeer');
    Route::post('paystack', 'paystack\ProcessController@ipn')->name('paystack');
    Route::post('voguepay', 'voguepay\ProcessController@ipn')->name('voguepay');
    Route::get('flutterwave/{trx}/{type}', 'flutterwave\ProcessController@ipn')->name('flutterwave');
    Route::post('razorpay', 'razorpay\ProcessController@ipn')->name('razorpay');
    Route::post('instamojo', 'instamojo\ProcessController@ipn')->name('instamojo');
    Route::get('blockchain', 'blockchain\ProcessController@ipn')->name('blockchain');
    Route::get('blockio', 'blockio\ProcessController@ipn')->name('blockio');
    Route::post('coinpayments', 'coinpayments\ProcessController@ipn')->name('coinpayments');
    Route::post('coinpayments_fiat', 'coinpayments_fiat\ProcessController@ipn')->name('coinpayments_fiat');
    Route::post('coingate', 'coingate\ProcessController@ipn')->name('coingate');
    Route::post('coinbase_commerce', 'coinbase_commerce\ProcessController@ipn')->name('coinbase_commerce');
    Route::get('mollie', 'mollie\ProcessController@ipn')->name('mollie');
    Route::post('cashmaal', 'cashmaal\ProcessController@ipn')->name('cashmaal');
});


// User Support Ticket
Route::prefix('ticket')->group(function () {
    Route::get('/', 'TicketController@supportTicket')->name('ticket');
    Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
    Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
    Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
});


/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetCodeEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify.code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');
		  // status checking
        Route::get('Status', 'AdminController@Status')->name('Status');

        //Manage Caching
        Route::get('/clearme', function(){
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');

            $notify[] = ['success','Successfully cache Cleared'];
            return redirect()->back()->withNotify($notify);
            return redirect()->route('dashboard', [$user])->withNotify($notify);

        });
 
        // Manage Currency
        Route::get('currency/all', 'CurrencyController@showAll')->name('currency');
        Route::get('currency/create', 'CurrencyController@create')->name('currency.create');
      Route::get('currency/delete/{id}', 'CurrencyController@delete')->name('currency.delete');
        Route::post('currency/create', 'CurrencyController@currencyAdd');
        Route::get('currency/edit/{currency}/{slug}', 'CurrencyController@editCurrency')->name('currency.edit');
        Route::post('currency/edit/{currency}/{slug}', 'CurrencyController@currencyUpdate');
        Route::get('currency/search', 'CurrencyController@currencysearch')->name('currency.search');
        Route::get('currency/ajax', 'CurrencyController@currencyAjax')->name('currency.ajax');

        // Exchange 

        Route::get('exchange/all', 'ExchangeController@index')->name('exchange.all');
        Route::get('exchange/details/{exchange}', 'ExchangeController@details')->name('exchange.details');
        Route::post('exchange/cancel/{exchange}', 'ExchangeController@cancle')->name('exchange.cancle');
        Route::post('exchange/approved/{exchange}', 'ExchangeController@approved')->name('exchange.approved');
        Route::post('exchange/refund/{exchange}', 'ExchangeController@refund')->name('exchange.refund');
        Route::get('exchange/delete/{exchange}', 'ExchangeController@delete')->name('exchange.delete');
        Route::get('exchange/approved', 'ExchangeController@approvedExchange')->name('exchange.total.approve');
        Route::get('exchange/pending', 'ExchangeController@pendingExchange')->name('exchange.total.pending');
        Route::get('exchange/refunded', 'ExchangeController@refundedExchange')->name('exchange.total.refund');
        Route::get('exchange/cancel', 'ExchangeController@canceledExchange')->name('exchange.total.cancel');

        Route::get('exchange/search', 'ExchangeController@search')->name('exchange.search');

        //Notification
        Route::get('notifications','AdminController@notifications')->name('notifications');
        Route::get('notification/read/{id}','AdminController@notificationRead')->name('notification.read');
        Route::get('notifications/read-all','AdminController@readAll')->name('notifications.readAll');


        // Refferal
        Route::get('refferal', 'RefferalController@refferal')->name('refferal');
        Route::post('refferal', 'RefferalController@refferalAdd');
        Route::get('reffer/user/{user}', 'AdminController@refferUser')->name('reffer.user');



        //Report Bugs
        Route::get('request-report','AdminController@requestReport')->name('request.report');
        Route::post('request-report','AdminController@reportSubmit');

        Route::get('system-info','AdminController@systemInfo')->name('system.info');


        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
        Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
        Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
        Route::get('users/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.email.verified');
        Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.email.unverified');
        Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.sms.unverified');
        Route::get('users/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.sms.verified');

        Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
        Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
        Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
        Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
        Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');
        Route::get('user/login/{id}', 'ManageUsersController@login')->name('users.login');
        Route::get('user/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');
        Route::get('user/deposits/{id}', 'ManageUsersController@deposits')->name('users.deposits');
        Route::get('user/deposits/via/{method}/{type?}/{userId}', 'ManageUsersController@depositViaMethod')->name('users.deposits.method');
        Route::get('user/withdrawals/{id}', 'ManageUsersController@withdrawals')->name('users.withdrawals');
        Route::get('user/withdrawals/via/{method}/{type?}/{userId}', 'ManageUsersController@withdrawalsViaMethod')->name('users.withdrawals.method');
        // Login History
        Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');
        Route::get('users/email-log/{id}', 'ManageUsersController@emailLog')->name('users.email.log');
        Route::get('users/email-details/{id}', 'ManageUsersController@emailDetails')->name('users.email.details');


        Route::get('users/posts/{id}', 'ManageUsersController@posts')->name('users.post.all');
        Route::get('users/tickets/{id}', 'ManageUsersController@tickets')->name('users.tickets');


        // Subscriber
        Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::get('subscriber/send-email', 'SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/remove', 'SubscriberController@remove')->name('subscriber.remove');
        Route::post('subscriber/send-email', 'SubscriberController@sendEmail')->name('subscriber.sendEmail');


        Route::get('category', 'CategoryController@index')->name('category');
        Route::post('add/category', 'CategoryController@add')->name('category.add');
        Route::post('update/category', 'CategoryController@update')->name('category.update');

        Route::get('sub/category', 'CategoryController@subCategory')->name('sub.category');
        Route::post('add/sub/category', 'CategoryController@addSubCategory')->name('add.sub.category');
        Route::post('update/sub/category', 'CategoryController@updateSubCategory')->name('update.sub.category');

        Route::get('forums', 'ForumController@index')->name('forum');
        Route::post('add/forum', 'ForumController@add')->name('forum.add');
        Route::post('update/forum', 'ForumController@update')->name('forum.update');

        Route::get('posts/pending', 'PostController@pending')->name('post.pending');
        Route::get('posts/approved', 'PostController@approved')->name('post.approved');
        Route::get('posts/reject/{id}', 'PostController@reject')->name('post.reject');
        Route::get('posts/comment', 'PostController@indexComment')->name('post.comment');
        Route::get('posts/delete/{id}', 'PostController@delete')->name('post.delete');
        Route::get('posts', 'PostController@posts')->name('post.all');
        Route::post('post/approve', 'PostController@approve')->name('post.approve');
        Route::get('post/details/{id}', 'PostController@details')->name('post.details');


        Route::get('advertisements', 'AdvertisementController@index')->name('ad');
        Route::post('create/ad', 'AdvertisementController@create')->name('ad.create');
        Route::post('update/ad', 'AdvertisementController@update')->name('ad.update');
        Route::post('delete/ad', 'AdvertisementController@delete')->name('ad.delete');




        // Deposit Gateway
        Route::name('gateway.')->prefix('gateway')->group(function(){
            // Automatic Gateway
            Route::get('automatic', 'GatewayController@index')->name('automatic.index');
            Route::get('automatic/edit/{alias}', 'GatewayController@edit')->name('automatic.edit');
            Route::post('automatic/update/{code}', 'GatewayController@update')->name('automatic.update');
            Route::post('automatic/remove/{code}', 'GatewayController@remove')->name('automatic.remove');
            Route::post('automatic/activate', 'GatewayController@activate')->name('automatic.activate');
            Route::post('automatic/deactivate', 'GatewayController@deactivate')->name('automatic.deactivate');
        });


        // WITHDRAW SYSTEM
        Route::name('withdraw.')->prefix('withdraw')->group(function () {
            Route::get('pending', 'WithdrawalController@pending')->name('pending');
            Route::get('approved', 'WithdrawalController@approved')->name('approved');
            Route::get('rejected', 'WithdrawalController@rejected')->name('rejected');
            Route::get('log', 'WithdrawalController@log')->name('log');
            Route::get('{scope}/search', 'WithdrawalController@search')->name('search');
            Route::get('details/{id}', 'WithdrawalController@details')->name('details');
            Route::post('approve', 'WithdrawalController@approve')->name('approve');
            Route::post('reject', 'WithdrawalController@reject')->name('reject');
        });

        // Report
        Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');
        Route::get('report/transaction/delete/{id}', 'ReportController@delete')->name('report.transaction.delete');
        Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');
        Route::get('report/login/history', 'ReportController@loginHistory')->name('report.login.history');
        Route::get('report/login/ipHistory/{ip}', 'ReportController@loginIpHistory')->name('report.login.ipHistory');


        // Admin Support
        Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
        Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
        Route::get('tickets/delete/{id}', 'SupportTicketController@delete')->name('tickets.delete');
        Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language.manage');
        Route::post('/language', 'LanguageController@langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdate')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language.key');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.importLang');



        Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');



        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');
        Route::get('optimize', 'GeneralSettingController@optimize')->name('setting.optimize');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css','GeneralSettingController@customCss')->name('setting.custom.css');
        Route::post('custom-css','GeneralSettingController@customCssSubmit');


        //Cookie
        Route::get('cookie','GeneralSettingController@cookie')->name('setting.cookie');
        Route::post('cookie','GeneralSettingController@cookieSubmit');


        // Plugin
        Route::get('extensions', 'ExtensionController@index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'ExtensionController@update')->name('extensions.update');
        Route::post('extensions/activate', 'ExtensionController@activate')->name('extensions.activate');
        Route::post('extensions/deactivate', 'ExtensionController@deactivate')->name('extensions.deactivate');

  // Refferal
        Route::get('refferal', 'RefferalController@refferal')->name('refferal');
        Route::post('refferal', 'RefferalController@refferalAdd');
        Route::get('reffer/user/{user}', 'AdminController@refferUser')->name('reffer.user');

        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email.template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email.template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email.template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email.template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email.template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email.template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email.template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email.template.test.mail');



        // SMS Setting
        Route::get('sms-template/global', 'SmsTemplateController@smsTemplate')->name('sms.template.global');
        Route::post('sms-template/global', 'SmsTemplateController@smsTemplateUpdate')->name('sms.template.global');
        Route::get('sms-template/setting','SmsTemplateController@smsSetting')->name('sms.templates.setting');
        Route::post('sms-template/setting', 'SmsTemplateController@smsSettingUpdate')->name('sms.template.setting');
        Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms.template.index');
        Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms.template.edit');
        Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms.template.update');
        Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('sms.template.test.sms');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');


        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {


            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');


            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');
 // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
            Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });
    });
});




/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/


Route::name('user.')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');
      Route::group(['middleware' => ['guest']], function () {
        Route::get('register/{reference}', 'Auth\RegisterController@referralRegister')->name('refer.register');
    });
    Route::post('check-mail', 'Auth\RegisterController@checkUser')->name('checkUser');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetCodeEmail')->name('password.email');
    Route::get('password/code-verify', 'Auth\ForgotPasswordController@codeVerify')->name('password.code.verify');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify.code');
});

Route::name('user.')->prefix('user')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');
        Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

        Route::middleware(['checkStatus'])->group(function () {
            Route::get('dashboard', 'UserController@home')->name('home');
            Route::get('doexchange', 'UserController@doexchange')->name('doexchange');

            Route::get('affiliate', 'AffiliateController@affiliate')->name('affiliate');
            Route::post('affiliate', 'AffiliateController@affiliateSend');

            Route::get('profile-setting', 'UserController@profile')->name('profile.setting');
            Route::post('profile-setting', 'UserController@submitProfile');
            Route::get('change-password', 'UserController@changePassword')->name('change.password');
            Route::post('change-password', 'UserController@submitPassword');

            //2FA
            Route::get('twofactor', 'UserController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'UserController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'UserController@disable2fa')->name('twofactor.disable');

            Route::get('create/topic', 'UserController@postForm')->name('post.form');
            Route::post('create/topic', 'UserController@postCreate')->name('post.create');
            Route::get('update/topic/{id}', 'UserController@updatePostForm')->name('post.update.form');
            Route::post('update/topic/', 'UserController@updatePost')->name('post.update');
            Route::post('delete/topic/', 'UserController@deletePost')->name('post.delete');
            Route::get('topics', 'UserController@posts')->name('post.all');

            Route::post('topic/reaction', 'UserController@reaction')->name('reaction');
            Route::post('topic/comment', 'UserController@comment')->name('comment');

          // exchange

            Route::get('exchange/preview', 'UserController@exchangepreview')->name('exchange.preview');
            Route::post('exchange/preview', 'UserController@exchangeConfirm');
            Route::get('exchange/transaction', 'UserController@transactionConfirmByTrx')->name('exchange.trnx');
            Route::post('exchange/transaction', 'UserController@transactionConfirmByTrxAdd');
            Route::get('exchange/transaction/success', 'UserController@transactionSuccess')->name('transaction.success');
            Route::get('exchange/history', 'UserController@exchangeHistory')->name('exchange.history');
            Route::get('exchange/pending', 'UserController@pendingExchange')->name('exchange.pending');
            Route::get('exchange/approved', 'UserController@approvedExchange')->name('exchange.approved');
            Route::get('exchange/refunded', 'UserController@refundedExchange')->name('exchange.refunded');
            Route::get('exchange/details/{exchange}', 'UserController@exchangeDetails')->name('exchange.details');
            Route::get('exchange/details/{exchange}', 'UserController@exchangeDetails')->name('exchange.details');
          
          Route::get('create/review', 'UserController@reviewForm')->name('review.form');
            Route::post('create/review', 'UserController@reviewCreate')->name('review.create');

            Route::get('reffer/log', 'UserController@refferLog')->name('reffer.log');

            Route::get('withdraw', 'UserController@withdrawForm')->name('withdraw');
            Route::post('withdraw', 'UserController@withdrawFormSubmit');
            Route::get('withdraw/preview', 'UserController@withdrawPreview')->name('withdraw.preview');
            Route::get('withdraw/log', 'UserController@withdrawLog')->name('withdraw.history');
            Route::get('withdraw/ajax/{currency}', 'UserController@withdrawAjax')->name('withdraw.ajax');
            Route::get('withdraw/amount', 'UserController@withdrawAjaxInput')->name('withdraw.ajax.amount');

            Route::get('deposit/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
           // Transaction
            Route::get('transactions', 'UserController@transactions')->name('transactions');

            // Referred Users
            Route::get('referred-users', 'UserController@referredUsers')->name('referred');
            Route::get('notifications', 'UserController@notifications')->name('notifications');

        });
    });
});

Route::get('community/posts', 'SiteController@allPost')->name('post.all');
Route::get('/contact', 'SiteController@contact')->name('contact');
Route::get('member/{slug}/','SiteController@user')->name('user');
Route::get('member/topics/{username}/{id}','SiteController@userTopics')->name('user.topics');
Route::get('member/answered/{username}/{id}','SiteController@userAnswer')->name('user.answer');
Route::get('member/up-vote/{username}/{id}','SiteController@userUpVote')->name('user.up.vote');
Route::get('member/down-vote/{username}/{id}','SiteController@userDownVote')->name('user.down.vote');

Route::get('ad-redirect/{hash}','SiteController@adRedirect')->name('adRedirect');
Route::get('forum/{slug}/{id}','SiteController@forum')->name('forum');
Route::get('category/{slug}/{id}','SiteController@categoryPosts')->name('category.post');
Route::get('sub/category/{slug}/{id}','SiteController@subCategoryPosts')->name('sub.category.post');
Route::get('{slug}/{id}','SiteController@postDetails')->name('post.details');
Route::get('/{slug}','SiteController@loveDetails')->name('love.details');
Route::get('topic/details/{slug}/{id}','SiteController@postDetails')->name('topic.details');
Route::post('load/more/comments', 'SiteController@moreComment')->name('more.comment');



Route::post('exchange', 'UserController@exchange')->name('user.exchange');
Route::get('/', 'SiteController@index')->name('home');

Route::post('/contact', 'SiteController@contactSubmit');;
Route::get('/cookie/accept', 'SiteController@cookieAccept')->name('cookie.accept');
Route::get('policy-pages/{page}/{id}', 'SiteController@policyPage')->name('policy.page');
Route::get('page/{slug}', 'SiteController@pages')->name('pages');



Route::get('more', 'SiteController@loadMore')->name('load');
Route::post('subscribe', 'SiteController@subscribe')->name('subscribe');
Route::get('ajax/code', 'UserController@ajaxCode');
Route::get('blog/{id}/{slug}', 'SiteController@blogDetails')->name('blog.details');


Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});



