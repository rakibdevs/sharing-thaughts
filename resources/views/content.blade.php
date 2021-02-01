@extends('layouts.main')
@section('title', $page->title??Auth::user()->name)
@section('content')
<div class="container p-0">
    <div class="content-wrap-body justify-content-center">
    	<div class="section-menu relative" data-simplebar>
    		<ul class=" nav-pills nav-sidebar section-nav" data-widget="treeview" role="menu" data-accordion="false">
                <li class="hide-section"><i class="fas fa-chevron-left"></i> Sections</li>
                @foreach($sections as $key => $item)
                <li class="nav-item section-key-{{$item->id}}">
                    <div class="nav-link @if(isset(request()->section) && request()->section == $item->id) active @endif  @if(!isset(request()->section)  && $key == 0) active @endif">
                        <p class="d-flex justify-content-between">
                            <span class="section-anchor" data-id="{{$item->id}}">
                                {{$item->title}}
                            </span>
                        
                            <span class="action-buttons">
                                <i class="fas fa-edit text-success section-edit" title="Edit"></i>
                                <i class="fas fa-trash text-danger section-delete" data-id="{{$item->id}}" title="Delete"></i>
                            </span> 
                        </p>
                    </div>
                    <div class="nav-item section-edit-area ">
                        <div class="d-flex">
                            @csrf
                            <input type="text" name="section" class="form-control" placeholder="Section Name" value="{{$item->title}}"> 
                            <span class="p-1">
                                <i class="fas fa-check text-success section-update" title="Update" data-id="{{$item->id}}"></i>
                                <i class="fas fa-times text-danger btn-close" title="Cancel"></i>
                            </span>
                        </div>
                    </div>
                </li>
                @endforeach        
            </ul>
            <div class="nav-item section-add @if(count(topics()) < 1) disabledarea @endif">
                <p  class="nav-link "> 
                <i class="fas fa-plus nav-icon"></i> Add New Section</p>
            </div>
            <div class="nav-item section-input hide">
                <div class="d-flex ml-3 ">
                    @csrf
                    <input id="section-name" type="text" name="section" class="form-control" placeholder="Section Name"> 
                    <button class="btn btn-success ml-1 section-store" data-topic="{{$parameter['topic']}}"><i class="fas fa-check"></i></button>
                </div>
            </div>
    	</div>
    	<div id="page-menu" class="page-menu" data-simplebar>
            
    		<ul class=" nav-pills nav-sidebar page-nav" data-widget="treeview" role="menu" data-accordion="false">
                <li class="hide-page"><i class="fas fa-chevron-left"></i> Pages</li>
                @foreach($pages as $key => $item)
                <li class="nav-item page-key-{{$item->id}}">
                    <a href="javascript:void(0);" class="nav-link @if(isset(request()->page) && request()->page == $item->id) active @endif  @if(!isset(request()->page)  && $key == 0) active @endif">
                        <p class="d-flex justify-content-between">
                            <span class="page-anchor"  data-id="{{$item->id}}">
                                {{$item->title}}
                            </span>
                        
                            <span class="action-buttons">
                                <i class="fas fa-trash text-danger page-delete" data-id="{{$item->id}}" title="Delete"></i>
                            </span> 
                        </p>
                    </a>
                </li>
                @endforeach        
            </ul>
            <div class="nav-item page-add @if(count($sections) < 1) disabledarea @endif" data-section="{{$parameter['section']}}" >
                <p  class="nav-link "> 
                <i class="fas fa-plus nav-icon"></i> Add New Page</p>
            </div>
            
    	</div>
    	<div class="page-content p-3" >
    		@include('append.page_content')
    	</div>
    </div>
</div>
@endsection