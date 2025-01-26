@extends('layout.app')

{{-- @dd($golpo) --}}
@section('content')
    <div class="card mb-3">
        @if (!empty($golpo->story_pic))
                            <img src="{{ asset('mobile_court/uploads/golpo/' . $golpo->story_pic) }}" alt="Story Image"
                                width="100%" height="450px">
                        @else
                        <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="100%" height="450">
                        @endif                                              
        <div class="card-body">
            <h5 class="card-title">{{$golpo->title}}</h5>
            <p class="card-text">{!! $golpo->details !!}</p>
            <p class="card-text" style="font-size: 20px; ">Created at: {{ $golpo->created_date ?? 'No Date Available' }}</p>
        </div>
    </div>
@endsection
