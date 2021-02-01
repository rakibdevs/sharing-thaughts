
<div id="page-menu" class="page-menu" data-simplebar>
    <ul class=" nav-pills nav-sidebar page-nav" data-widget="treeview" role="menu" data-accordion="false">
        <li class="hide-page"><i class="fas fa-chevron-left"></i> Pages</li>
        @foreach($section->page as $key => $item)
        <li class="nav-item page-key-{{$item->id}}">
            <a href="javascript:void(0);" class="nav-link @if($key == 0)active @endif">
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
    <div class="nav-item page-add" data-section="{{$section->id}}">
        <p  class="nav-link "> 
        <i class="fas fa-plus nav-icon"></i> Add new Page</p>
    </div>
</div>