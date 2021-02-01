<!-- modal for create new topic -->
<div class="modal" id="modal-share" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="share-title"></strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                </div>
            <div class="modal-body text-center">
                <button class="btn btn-primary share-public">
                    Share with all
                </button>
               
                <p class="text-center text-muted mt-2">Or</p>
                Choose people (Private)
                <div class="form-group row">
                    <div class="col-sm-9">
                        <select class="share-to-user form-control" name="shared-with[]" data-placeholder='Choose from here' multiple style="width: 300px;">
                            @foreach(users() as $key => $user)
                                <option value="{{$key}}">{{$user}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        
                        <button class="btn btn-primary share-private">Share</button>
                    </div>
                </div>

                

            </div>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- modal edit -->

<!-- modal for create new topic -->
<div class="modal" id="modal-share-edit" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>