@extends($activeTemplate.'layouts.exchange')

@section('content')


    @if($sections != null)
        @foreach(json_decode($sections) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
