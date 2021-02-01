@extends('layouts.main')
@section('title', "Shared with me")
@section('content')
<div class="container p-0" >
    <div class="content-wrap-body search-result" data-simplebar>
        
        <p class="p-3 m-0">Total shared {{toBangla(count($results))}} contents</p class="p-3 m-0">
        <div class="col-sm-12">
            
            <div class="row m-0">
                @foreach ($results as $item)
                    <!-- highlight text -->

                    <div class="col-sm-4">
                        <div class="result-item p-3 mb-3">
                            
                            <div class="title mb-2">
                          		<h5 class="p-0 m-0"><strong><a href="{{url('shared',['id' => $item->id, 'slug' => $item->slug])}}">{!!$item->title!!}</a></strong></h5>
                                <span class="text-muted text-small"> {{ toBangla($item->created_at)}} . <span class="text-green">{{$item->user['name']??''}}</span></span>


                          	</div>
                            <div class="min-150">
                                
                              	{!!$item->auto_excerpt!!}...<a href="{{url('shared',['id' => $item->id, 'slug' => $item->slug])}}">Read More</a>
                            </div>

                            <div>
                                <!-- topic and section -->
                                @if($item->section)
                                    @if($item->section->topic)
                                        <i class="fas fa-tag"></i>  <span class="text-green">{{ $item->section->topic->title}}</span> | 
                                    @endif

                                  <span class="text-pending">{{ $item->section->title}}</span>
                                @endif

                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
