<nav>
    <ul>
        <li><a href="/Hospitals">Hospitals</a></li>
        <li><a href="/Schedule">Schedule</a></li>
        <li><a href="/Hospitals/Admin">Admin</a></li>
        <li><form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit">Logout</button>
        </form></li>
        <li><a href="/Search"><i class="fa-solid fa-magnifying-glass"></i></a></li>
    </ul>
</nav>
