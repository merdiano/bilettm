{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
{{--<li class="treeview">--}}
{{--    <a class="nav-link" href="#"><i class="fa fa-group"></i> <span>CRUD ...</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
{{--    <ul class="treeview-menu">--}}
{{--        --}}
{{--        <li class="nav-item"><a class="nav-link" href='{{ backpack_url('tag') }}'><i class='fa fa-tag'></i> <span>Tags</span></a></li>--}}
{{--        --}}{{--<li class="nav-item"><a class="nav-link" href='{{ backpack_url('country') }}'><i class='fa fa-tag'></i> <span>Countries</span></a></li>--}}
{{--        <li class="nav-item"><a class="nav-link" href='{{ backpack_url('event') }}'><i class='fa fa-glass'></i> <span>Events</span></a></li>--}}
{{--        --}}
{{--    </ul>--}}
{{--</li>--}}
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>--}}
<li class="nav-item"><a class="nav-link" href='{{ backpack_url('slider') }}'><i class='fa fa-image'></i> <span>Sliders</span></a></li>
<li class="nav-item"><a class="nav-link" href='{{ backpack_url('category') }}'><i class='fa fa-tag'></i> <span>Categories</span></a></li>
<li class="nav-item"><a class="nav-link" href='{{ backpack_url('venue') }}'><i class='fa fa-tag'></i> <span>Venues</span></a></li>
<li class="nav-item"><a class="nav-link" href='{{ backpack_url('section') }}'><i class='fa fa-align-center'></i> <span>Sections</span></a></li>
<li class="nav-item"><a class="nav-link" href='{{ backpack_url('page') }}'><i class='fa fa-file-o'></i> <span>Pages</span></a></li>
<li class="nav-item"><a class="nav-link" href='{{ backpack_url('subscriber') }}'><i class='fa fa-tag'></i> <span>Subscribers</span></a></li>
<li class="nav-item"><a class="nav-link" href='{{ backpack_url('helpTopic') }}'><i class='fa fa-tag'></i> <span>Help Topics</span></a></li>
<li class="nav-item"><a class="nav-link" href='{{ backpack_url('setting') }}'><i class='fa fa-cog'></i> <span>Settings</span></a></li>
<li class="nav-item"><a class="nav-link" href='{{ backpack_url('backup') }}'><i class='fa fa-hdd-o'></i> <span>Backups</span></a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('account') }}"><i class="nav-icon la la-question"></i> Accounts</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('slider') }}"><i class="nav-icon la la-question"></i> Sliders</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('sector') }}"><i class="nav-icon la la-question"></i> Sectors</a></li>