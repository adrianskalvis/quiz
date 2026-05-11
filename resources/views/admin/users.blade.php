<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Users</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('admin.partials.style')
</head>
<body>
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
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:30px;height:30px;border-radius:50%;background:rgba(80,160,255,0.2);border:0.5px solid rgba(80,160,255,0.3);display:flex;align-items:center;justify-content:center;font-size:12px;color:rgba(140,200,255,0.9);font-weight:500;flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span>{{ $user->name }}</span>
                                @if($user->id === Auth::id())
                                    <span style="font-size:10px;color:rgba(255,255,255,0.3)">(you)</span>
                                @endif
                            </div>
                        </td>
                        <td style="color:rgba(255,255,255,0.5);font-size:12px">{{ $user->email }}</td>
                        <td><span class="role-badge role-{{ $user->role }}">{{ $user->role }}</span></td>
                        <td style="color:rgba(255,255,255,0.5)">{{ $user->attempts_count }}</td>
                        <td style="color:rgba(255,255,255,0.4);font-size:12px">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div style="display:flex;gap:6px;align-items:center;">
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
                                          onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-danger">Delete</button>
                                    </form>
                                @else
                                    <span style="color:rgba(255,255,255,0.2);font-size:12px">—</span>
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
