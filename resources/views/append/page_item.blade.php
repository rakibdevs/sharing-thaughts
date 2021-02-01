<li class="nav-item page-key-{{$page->id}}">
    <a href="javascript:void(0);" class="nav-link active">
        <p class="d-flex justify-content-between">
            <span class="page-anchor"  data-id="{{$page->id}}">
                {{$page->title}}
            </span>
        
            <span class="action-buttons">
                <i class="fas fa-trash text-danger page-delete" data-id="{{$page->id}}" title="Delete"></i>
            </span> 
        </p>
    </a>
</li>