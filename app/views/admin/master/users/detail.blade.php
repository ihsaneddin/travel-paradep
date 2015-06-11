<dl class="dl-horizontal">
    <dt>Username</dt>
    <dd>: {{ $user->username }}</dd>
    <dt>Station</dt>
    <dd>: {{ $user->station->name }}</dd>
    <dt>Role</dt>
    <dd>: {{ $user->rolesName() }}</dd>
    <dt>Last Login</dt>
    <dd>: {{ $user->lastLogin() }}</dd>
</dl>