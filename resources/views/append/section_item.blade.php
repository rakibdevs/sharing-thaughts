<li class="nav-item section-key-{{$section->id}}">
    <div class="nav-link">
        <p class="d-flex justify-content-between">
            <span class="section-anchor" data-id="{{$section->id}}">
                {{$section->title}}
            </span>
        
            <span class="action-buttons">
                <i class="fas fa-edit text-success section-edit" title="Edit"></i>
                <i class="fas fa-trash text-danger section-delete" data-id="{{$section->id}}" title="Delete"></i>
            </span> 
        </p>
    </div>
    <div class="nav-item section-edit-area ">
        <div class="d-flex">
            @csrf
            <input type="text" name="section" class="form-control" placeholder="Section name" value="{{$section->title}}"> 
            <span class="p-1">
                <i class="fas fa-check text-success section-update" title="Update" data-id="{{$section->id}}"></i>
                <i class="fas fa-times text-danger btn-close" title="Cancel"></i>
            </span>
        </div>
    </div>
</li>