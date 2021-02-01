<div style="height: 100%;" data-simplebar>
@if($page != null)
	<div class="title ">
		<h3 class="p-0"><strong class="memory-page-title">{{$page->title??''}}</strong></h3>
		<span class="text-muted text-small"> {{ toBangla($page->created_at??'')}}</span> 
		@if(auth()->id() == $page->created_by)
		. <span class="page-edit text-small" data-id="{{$page->id}}"><i class="fas fa-edit"></i> Edit</span>
			.
			@if($page->shared == 1)
				<span class="page-share-edit text-small" data-toggle="modal" data-target="#modal-share-edit" data-id="{{$page->id}}" data-title="{{$page->title}}" data-shared="all"><i class="fas fa-share"></i> Shared with all</span>
			@else
				@if($page->share != null && count($page->share) > 0)
					<span class="page-share-edit text-small" data-toggle="modal" data-target="#modal-share-edit" data-id="{{$page->id}}" data-title="{{$page->title}}" data-shared="user"><i class="fas fa-share"></i> Shared with
					{{count($page->share)}} people </span>
				@else
			 	<span class="page-share text-small" data-toggle="modal" data-target="#modal-share" data-id="{{$page->id}}" data-title="{{$page->title}}"><i class="fas fa-share"></i> Share</span>
			 	@endif
			@endif
		@endif
		<hr>
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
	<p class="text-center">No page found!</p>
@endif
</div>

