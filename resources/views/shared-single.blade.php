@extends('layouts.main')
@section('title', $page->title??'Not found!')
@section('content')
<div class="container p-0" >
    <div class="content-wrap-body search-result" data-simplebar>
    	<div class="p-3">
    		
	    	@if($page != null)
			<div class="title ">
				<p>
				<!-- topic and section -->
	                @if($page->section)
	                    @if($page->section->topic)
	                        <i class="fas fa-tag"></i>  <span class="text-green">{{ $page->section->topic->title}}</span> | 
	                    @endif

	                  <span class="text-pending">{{ $page->section->title}}</span>
	                @endif
	            </p>
				<h3 class="p-0"><strong class="memory-page-title">{{$page->title??''}}</strong></h3>
				<span class="text-muted"> {{ toBangla($page->created_at??'')}} . by <strong>{{$page->user['name']??''}}</strong></span>
			</div>
			
			<div class="mt-3">
				{!!$page->content!!}
			</div>
			@if($page->attatchments != null)
			<div class="mt-3">
				<label>Attatchments</label>
				<ul>
					@foreach($page->attatchments as $key => $att)
					<li><a rel="group" target="_blank" class="fancy" href="{{asset($att->url)}}">{{$att->name}}</a> <span class="att-delete text-small text-danger" data-id="{{$att->id}}"><i class="fas fa-trash"></i></li>
					@endforeach
				</ul>
			</div>
			@endif
			@else
				<p class="text-center">Page not found!</p>
			@endif
    	</div>
			
    </div>
</div>
@endsection