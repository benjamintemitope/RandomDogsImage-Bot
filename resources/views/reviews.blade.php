{{-- https://bootsnipp.com/snippets/3Al5m --}}
@extends('layouts.app')
@section('content')
<!-- Page Content -->
    <div class="container">

      <!-- Page Heading -->
      <h1 class="mt-4 pb-2">Reviews
      </h1>
    
        @foreach ($reviews as $review)
            <div>
                <div class="col-md-10">
                    <blockquote class="custom-blockquote">
                        <p>{{ $review->body }}</p>
                        <cite> {{ $review->subscriber->name }}</cite>
                    </blockquote>
                    <div>
                        <span>
                            <i class="fa fa-user-o"></i> {{ $review->subscriber->name }},
                        </span> 
                        <span>
                            <i class="fa fa-key"></i> {{ $review->subscriber->id }},
                        </span>
                        <span>
                            <i class="fa fa-clock-o"></i> {{ 
                                \Carbon\Carbon::parse($review->created_at)->diffForHumans() 
                                 }}
                        </span>
                    </div>
                </div>
                <hr>
            </div>
        @endforeach
      

      
      <!-- Pagination -->
      {{ $reviews->links() }}

    </div>
    <!-- /.container -->

@endsection