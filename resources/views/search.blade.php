@extends('layouts.main')
@section('title', "Search results of '".request()->keyword."' ")
@section('content')
<div class="container p-0" >
    <div class="content-wrap-body search-result" data-simplebar>
        
        <p class="p-3 m-0">Total results found {{toBangla(count($results))}}</p class="p-3 m-0">
        <div class="col-sm-12">
            
            <div class="row m-0">
                @foreach ($results as $item)
                    <!-- highlight text -->
                    @php
                        $text_title = $item->title;
                        $text_content = $item->auto_excerpt;

                        foreach($keywords as $key => $keyword)
                        {
                            $highlighted = "<span class='text-danger'>$keyword</span>";
                            $text_title = str_ireplace($keyword, $highlighted, $text_title);
                            $text_content = str_ireplace($keyword, $highlighted, $text_content);

                        }

                        if($item->own == true){
                            $uri = url('content?');
                            if(isset($item->section->topic)){
                                $uri .= 'topic='.$item->section->topic->id;
                            }
                            if(isset($item->section)){ 
                                $uri .= '&section=' .$item->section->id;
                            } 
                            $uri .= '&page='.$item->id;
                        }else{
                            $uri = url('shared',['id' => $item->id, 'slug' => $item->slug]);
                        }
                    @endphp
                    <div class="col-sm-4">
                        <div class="result-item p-3 mb-3 @if($item->own == false) shared-item @endif">
                            
                            <div class="title mb-2">
                          		<h5 class="p-0 m-0"><strong><a href="{{$uri}}">{!!$text_title!!}</a></strong></h5>
                                <span class="text-muted text-small"> {{ toBangla($item->created_at)}}
                                    @if($item->own == false)
                                    . <span class="text-green">{{$item->user['name']??''}}</span>
                                    @endif
                                </span>

                          	</div>
                            
                            <div class="min-150">
                                
                              	{!!$text_content!!}...<a href="{{$uri}}">Read More</a>
                            </div>

                            <div>
                                <!-- topic and section -->
                                @if($item->section)
                                    @if($item->section->topic)
                                        <i class="fas fa-tag"></i> <span class="text-green">{{ $item->section->topic->title}} </span> | 
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
