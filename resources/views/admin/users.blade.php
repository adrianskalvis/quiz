<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Users</title>
    @vite(['resources/css/app.css', 'resources/css/pages/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
<x-quiz-nav />
<div class="admin-page">
    @include('admin.partials.sidebar')
    <main class="admin-main">
        <div class="admin-header">
            <h1>Users</h1>
            <p>Manage user accounts and roles</p>
        </div>

        @if(session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
        @endif

        <div class="acard">
            <div class="acard-header">
                <h2>All users ({{ $users->count() }})</h2>
            </div>
            <table class="atable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Attempts</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="user-cell-admin">
                                <div class="user-avatar-admin">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span>{{ $user->name }}</span>
                                @if($user->id === Auth::id())
                                    <span class="admin-muted-note">(you)</span>
                                @endif
                            </div>
                        </td>
                        <td class="td-muted-small">{{ $user->email }}</td>
                        <td><span class="role-badge role-{{ $user->role }}">{{ $user->role }}</span></td>
                        <td class="td-muted">{{ $user->attempts_count }}</td>
                        <td class="td-subtle-small">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="row-actions">
                                @if($user->id !== Auth::id())
                                    <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="role"
                                               value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                                        <button type="submit" class="btn-edit">
                                            {{ $user->role === 'admin' ? '↓ Make user' : '↑ Make admin' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                          data-confirm="Delete {{ addslashes($user->name) }}? This cannot be undone.">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-danger">Delete</button>
                                    </form>
                                @else
                                    <span class="unavailable-mark">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
