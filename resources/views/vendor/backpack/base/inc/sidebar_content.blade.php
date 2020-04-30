<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<!-- Users, Roles Permissions -->
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Accounts, Organizers</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
        <li><a href="{{ backpack_url('account') }}"><i class="fa fa-group"></i> <span>Accounts</span></a></li>
        <li><a href="{{ backpack_url('organiser') }}"><i class="fa fa-key"></i> <span>Organizers</span></a></li>
    </ul>
</li>
{{--<li class="treeview">--}}
{{--    <a href="#"><i class="fa fa-group"></i> <span>CRUD ...</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
{{--    <ul class="treeview-menu">--}}
{{--        --}}
{{--        <li><a href='{{ backpack_url('tag') }}'><i class='fa fa-tag'></i> <span>Tags</span></a></li>--}}
{{--        --}}{{--<li><a href='{{ backpack_url('country') }}'><i class='fa fa-tag'></i> <span>Countries</span></a></li>--}}
{{--        <li><a href='{{ backpack_url('event') }}'><i class='fa fa-glass'></i> <span>Events</span></a></li>--}}
{{--        --}}
{{--    </ul>--}}
{{--</li>--}}
{{--<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>--}}
<li><a href='{{ backpack_url('slider') }}'><i class='fa fa-image'></i> <span>Sliders</span></a></li>
<li><a href='{{ backpack_url('category') }}'><i class='fa fa-tag'></i> <span>Categories</span></a></li>
<li><a href='{{ backpack_url('venue') }}'><i class='fa fa-tag'></i> <span>Venues</span></a></li>
<li><a href='{{ backpack_url('section') }}'><i class='fa fa-align-center'></i> <span>Sections</span></a></li>
<li><a href='{{ backpack_url('page') }}'><i class='fa fa-file-o'></i> <span>Pages</span></a></li>
<li><a href='{{ backpack_url('subscriber') }}'><i class='fa fa-tag'></i> <span>Subscribers</span></a></li>
<li><a href='{{ backpack_url('helpTicketCategory') }}'><i class='fa fa-tag'></i> <span>Help Topics</span></a></li>
<li><a href='{{ backpack_url('setting') }}'><i class='fa fa-cog'></i> <span>Settings</span></a></li>
<li><a href='{{ backpack_url('backup') }}'><i class='fa fa-hdd-o'></i> <span>Backups</span></a></li>


