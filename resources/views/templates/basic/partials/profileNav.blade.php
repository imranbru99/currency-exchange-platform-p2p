{{-- <nav class="profile-nav p-0 navbar navbar-expand-md">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#profileNavbar" aria-controls="profileNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="las la-bars"></i> <span>@lang('Menu')</span>
      </button>
      <div class="collapse navbar-collapse" id="profileNavbar">
        <ul class="profile-menu m-auto">
        <li class='{{ Route::currentRouteName() == 'user' ? 'active' : '' }}'>
            <a href="{{ route('user', ['username'=>$user->username, 'id'=>$user->id]) }}">
            <i class="las la-user-circle"></i>
            @lang('Bio')</a>
        </li>
        <li class='{{ Route::currentRouteName() == 'user.topics' ? 'active' : '' }}'>
            <a href="{{ route('user.topics', ['username'=>$user->username, 'id'=>$user->id]) }}">
            <i class="las la-clipboard-list"></i>
            @lang('Topics')</a>
        </li>
        <li class='{{ Route::currentRouteName() == 'user.answer' ? 'active' : '' }}'>
            <a href="{{ route('user.answer', ['username'=>$user->username, 'id'=>$user->id]) }}">
            <i class="las la-clipboard-check"></i>
            @lang('Answered')</a>
        </li>
        <li class='{{ Route::currentRouteName() == 'user.up.vote' ? 'active' : '' }}'>
            <a href="{{ route('user.up.vote', ['username'=>$user->username, 'id'=>$user->id]) }}">
            <i class="las la-arrow-up"></i>
            @lang('Up Vote')</a>
        </li>
        <li class='{{ Route::currentRouteName() == 'user.down.vote' ? 'active' : '' }}'>
            <a href="{{ route('user.down.vote', ['username'=>$user->username, 'id'=>$user->id]) }}">
            <i class="las la-arrow-down"></i>
            @lang('Down Vote')</a>
        </li>
        </ul>
      </div>
    </div>
</nav> --}}
