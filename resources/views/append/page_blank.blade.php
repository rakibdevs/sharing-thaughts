<div class="p-3" style="height: 100%;" data-simplebar>
	<form id="page-form" enctype="multipart/form-data">
		@csrf
		<div class="form-group">
			<label>Title</label>
			<input type="text" name="title" class="form-control page-title">
			<input type="hidden" name="section_id" class="form-control page-section-id" value="{{$section_id}}">
		</div>
		<div class="form-group">
			<textarea name="content"  class="pagecontent form-control"></textarea>
		</div>
		<div class="form-group att-area">
			<label>Attatchments</label>
			<div class="att-item">
				<input type="file" name="attatcement[]" placeholder="Select file"> <input type="text" name="name[]" placeholder="Type file name"> <button type="button" class="btn btn-success btn-sm add-attatchment">&#10010;</button> <!-- <button type="button" class="btn btn-danger btn-sm remove-attatchment">&#10006;</button> -->
			</div>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-primary page-save" >Save</button>
		</div>
	</form>

</div>