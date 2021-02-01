<li class="nav-item nav-key-{{$topic->id}}">
    <div href="javascript:void(0);" class="nav-link">
        <p class="d-flex justify-content-between">
            <a class="w-100" href="{{url('content')}}?topic={{$topic->id}}">
                <i class="far fa-circle nav-icon"></i>
                {{$topic->title}}
            </a>
                            
        
            <span class="action-buttons">
                <i class="fas fa-edit text-success topic-edit" title="Edit"></i>
                <i class="fas fa-trash text-danger topic-delete" data-id="{{$topic->id}}" title="Delete"></i>
            </span> 
        </p>
    </div>
    <div class="nav-item topic-edit-area ">
        <div class="d-flex ml-3 ">
            @csrf
            <input type="text" name="topic" class="form-control" placeholder="Topic Name" value="{{$topic->title}}"> 
            <span class="p-1">
                <i class="fas fa-check text-success topic-update" title="Update" data-id="{{$topic->id}}"></i>
                <i class="fas fa-times text-danger btn-close" title="Cancel"></i>
            </span>
        </div>
    </div>
</li>