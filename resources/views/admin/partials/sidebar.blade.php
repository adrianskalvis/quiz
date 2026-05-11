<aside class="sidebar">
    <div class="sidebar-title">Admin panel</div>
    <a href="{{ route('admin.index') }}"        class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
        <span class="s-icon">🏠</span> Overview
    </a>
    <a href="{{ route('admin.users.index') }}"  class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <span class="s-icon">👥</span> Users
    </a>
    <a href="{{ route('admin.topics.index') }}" class="{{ request()->routeIs('admin.topics.*') || request()->routeIs('admin.questions.*') ? 'active' : '' }}">
        <span class="s-icon">📚</span> Topics & Questions
    </a>
    <a href="{{ route('quizes') }}" class="back-link">
        <span class="s-icon">←</span> Back to quizzes
    </a>
</aside>
