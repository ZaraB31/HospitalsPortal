<nav>
    <ul>
        <li><a href="/Hospitals">Hospitals</a></li>
        <li><a href="/Schedule">Schedule</a></li>
        <li><a href="/Hospitals/Admin">Admin</a></li>
        <li><form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit">Logout</button>
        </form></li>
    </ul>
</nav>