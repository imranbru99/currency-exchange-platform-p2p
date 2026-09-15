@extends($activeTemplate.'layouts.frontend')

@section('content')

	<section class="blog-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                	<p>
                		@php
                			echo __($policy->description)
                		@endphp
                	</p>
                </div>
            </div>
        </div>
    </section>


@endsection