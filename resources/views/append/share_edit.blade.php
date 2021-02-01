<div class="modal-header">
    <strong class="share-title">{{$page->title??''}}</strong>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    </div>
<div class="modal-body text-center">
    @if($share == 'all')
        <button class="btn btn-danger share-public-remove" data-id="{{$page->id}}">
            Cancel sharing
        </button>
    @else
        <button class="btn btn-primary share-public" data-id="{{$page->id}}">
            Share with all
        </button>
    @endif
   
    <p class="text-center text-muted mt-2">Or</p>
   Choose people (Private)
    <div class="form-group row">
        <div class="col-sm-8">
            <select class="share-to-user form-control" name="shared-with[]" data-placeholder='Choose from here' multiple style="width: 300px;">
                @foreach(users() as $key => $user)
                <option value="{{$key}}" @if(in_array($key, $shared_with)) selected="selected" @endif>{{$user}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-4">
            @if($share != 'user')
            <button class="btn btn-primary share-private" data-id="{{$page->id}}">Share</button>
            @endif
            @if($share == 'user')
                <button class="btn btn-primary share-update" data-id="{{$page->id}}">Share</button>
                <button class="btn btn-danger share-private-remove" data-id="{{$page->id}}">
                    Cancel
                </button>
            @endif
        </div>
    </div>
</div>