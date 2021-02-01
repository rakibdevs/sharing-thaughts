<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('')}}" class="brand-link">
        <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">Diary</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        @if(Auth::user())
        <div class="info">
            <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
        @endif
    </div>

      <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview @if(request()->segment(1) == '' || request()->segment(1) == 'content') menu-open @endif">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-file-alt"></i>
                    <p>Topics<i class="right fas fa-angle-left"></i></p>
                </a>
                <!-- topic list -->
                <ul class="nav nav-treeview topic-list">
                    @foreach(topics() as $key => $item)

                    <li class="nav-item nav-key-{{$item->id}}">
                        <div class="nav-link @if(isset(request()->topic) && request()->topic == $item->id) active @endif  @if(!isset(request()->topic) && isset($parameter['topic'])  && $parameter['topic'] == $item->id) active @endif">
                            <p class="d-flex justify-content-between">
                                <a class="w-100" href="{{url('content')}}?topic={{$item->id}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    {{$item->title}}
                                </a>
                            
                                <span class="action-buttons">
                                    <i class="fas fa-edit text-success topic-edit" title="Edit"></i>
                                    <i class="fas fa-trash text-danger topic-delete" data-id="{{$item->id}}" title="মুছে ফেলুন"></i>
                                </span> 
                            </p>
                        </div>
                        <div class="nav-item topic-edit-area ">
                            <div class="d-flex ml-3 ">
                                @csrf
                                <input type="text" name="topic" class="form-control" placeholder="Topic name" value="{{$item->title}}"> 
                                <span class="p-1">
                                    <i class="fas fa-check text-success topic-update" title="Update" data-id="{{$item->id}}"></i>
                                    <i class="fas fa-times text-danger btn-close" title="Cancel"></i>
                                </span>
                            </div>
                        </div>
                    </li>
                    @endforeach        
                </ul>
            </li>
            <li class="nav-item topic-add p-0">
                <p  class="nav-link text-white  "> 
                <i class="fas fa-plus nav-icon"></i>Add new topic</p>
            </li>
            <li class="nav-item topic-input hide">
                <div class="d-flex ml-3 ">
                    @csrf
                    <input id="topic-name" type="text" name="topic" class="form-control" placeholder="Type topics name"> 
                    <button class="btn btn-success ml-1 topic-store"><i class="fas fa-check"></i></button>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{url('shared')}}" class="nav-link @if( request()->segment(1) == 'shared') active @endif">
                    <i class="nav-icon fab fa-buffer"></i>
                    <p>Shared with me</p>
                </a>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
  </aside>