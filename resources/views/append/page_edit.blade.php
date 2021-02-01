<div class="p-3" style="height: 100%; z-index:1050" data-simplebar>
	<form id="page-form" enctype="multipart/form-data">
		@csrf
		<div class="form-group">
			<label>Title</label>
			<input type="text" name="title" class="form-control page-title" value="{{$page->title}}">
		</div>
		<div class="form-group">
			<textarea name="content"  class="pagecontent form-control">{!!$page->content!!}</textarea>
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
		<div class="form-group att-area">
			<label>New Attatchment</label>
			<div class="att-item">
				<input type="file" name="attatcement[]" placeholder="Select a file"> <input type="text" name="name[]" placeholder="File name"> <button type="button" class="btn btn-success btn-sm add-attatchment">&#10010;</button> <!-- <button type="button" class="btn btn-danger btn-sm remove-attatchment">&#10006;</button> -->
			</div>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-primary page-update" data-id="{{$page->id}}">Save</button>
		</div>
	</form>
</div>