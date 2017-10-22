<li class="dropdown">
    <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="http://gravatar.com/avatar/{{md5(Auth::user()->user_email)}}?d=mm" alt="user-img" class="img-circle"> </a>
    <ul class="dropdown-menu">
        <li><a href="/admin/users/{{Auth::user()->user_id}}"><i class="ti-user m-r-5"></i> Account</a></li>
        <li><a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ti-power-off m-r-5"></i> Logout</a>
        </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</li>