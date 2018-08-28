@if (Auth::guard('web')->check())
    <p class="text-success">
        You're logged in as <strong>User</strong>
    </p>
@else
    <p class="text-danger">
        You're logged out as <strong>User</strong>
    </p>
@endif

@if (Auth::guard('admin')->check())
    <p class="text-success">
        You're logged in as <strong>Admin</strong>
    </p>
@else
    <p class="text-danger">
        You're logged out as <strong>Admin</strong>
    </p>
@endif
