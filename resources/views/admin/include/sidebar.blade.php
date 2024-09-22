<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('admin/dashboard') }}">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('admin/dashboard') }}"></a>
        </div>

        <ul class="sidebar-menu">

            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/dashboard') }}"><i class="fas fa-hand-point-right"></i> <span>Dashboard</span></a></li>
            <li class="{{ Request::is('admin/slider') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/slider') }}"><i class="fas fa-hand-point-right"></i> <span>Slider</span></a></li>
            <li class="{{ Request::is('admin/special') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/special') }}"><i class="fas fa-hand-point-right"></i> <span>Special</span></a></li>
            <li class="{{ Request::is('admin/feature') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/feature') }}"><i class="fas fa-hand-point-right"></i> <span>Feature</span></a></li>
            <li class="{{ Request::is('admin/testimonial') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/testimonial') }}"><i class="fas fa-hand-point-right"></i> <span>Testimonial</span></a></li>
            <li class="{{ Request::is('admin/counter') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/counter') }}"><i class="fas fa-hand-point-right"></i> <span>Counter</span></a></li>
            <li class="{{ Request::is('admin/faqs') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/faqs') }}"><i class="fas fa-hand-point-right"></i> <span>FAQs</span></a></li>
            <li class="{{ Request::is('admin/volunteer') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/volunteer') }}"><i class="fas fa-hand-point-right"></i> <span>Volunteer</span></a></li>

            <li class="nav-item dropdown {{ Request::is('admin/photo-category') || Request::is('admin/photo') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-hand-point-right"></i><span>Photo Gallery</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/photo-category') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/photo-category') }}"><i class="fas fa-angle-right"></i>Categories</a></li>
                    <li class="{{ Request::is('admin/photo') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/photo') }}"><i class="fas fa-angle-right"></i>Photos</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ Request::is('admin/video-category') || Request::is('admin/video') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-hand-point-right"></i><span>Video Gallery</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/video-category') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/video-category') }}"><i class="fas fa-angle-right"></i>Categories</a></li>
                    <li class="{{ Request::is('admin/video') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/video') }}"><i class="fas fa-angle-right"></i>Videos</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ Request::is('admin/post-category') || Request::is('admin/post') || Request::is('admin/comments') || Request::is('admin/replies') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-hand-point-right"></i><span>Blog Section</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/post-category') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/post-category') }}"><i class="fas fa-angle-right"></i>Categories</a></li>
                    <li class="{{ Request::is('admin/post') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/post') }}"><i class="fas fa-angle-right"></i>Posts</a></li>
                    <li class="{{ Request::is('admin/comments') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/comments') }}"><i class="fas fa-angle-right"></i>Comments</a></li>
                    <li class="{{ Request::is('admin/replies') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/replies') }}"><i class="fas fa-angle-right"></i>Replies</a></li>
                </ul>
            </li>

            <li class="{{ Request::is('admin/event') ? 'active' : '' }}"><a class="nav-link" href="{{ url('admin/event') }}"><i class="fas fa-hand-point-right"></i> <span>Event</span></a></li>


            {{-- <li class=""><a class="nav-link" href="setting.html"><i class="fas fa-hand-point-right"></i> <span>Setting</span></a></li>

            <li class=""><a class="nav-link" href="form.html"><i class="fas fa-hand-point-right"></i> <span>Form</span></a></li>

            <li class=""><a class="nav-link" href="table.html"><i class="fas fa-hand-point-right"></i> <span>Table</span></a></li>

            <li class=""><a class="nav-link" href="invoice.html"><i class="fas fa-hand-point-right"></i> <span>Invoice</span></a></li> --}}

        </ul>
    </aside>
</div>