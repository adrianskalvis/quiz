<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ $topic ? 'Edit' : 'New' }} Topic</title>
    @vite(['resources/css/app.css', 'resources/css/pages/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
<x-quiz-nav />
<div class="admin-page">
    @include('admin.partials.sidebar')
    <main class="admin-main">
        <div class="admin-header">
            <h1>{{ $topic ? 'Edit topic' : 'New topic' }}</h1>
            <p>{{ $topic ? $topic->name : 'Fill in the details below' }}</p>
        </div>

        @if($errors->any())
            <div class="flash flash-error">{{ $errors->first() }}</div>
        @endif

        <div class="acard acard-topic-form">
            <div class="acard-header"><h2>Topic details</h2></div>
            <div class="acard-body">
                <form method="POST"
                      action="{{ $topic ? route('admin.topics.update', $topic) : route('admin.topics.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($topic) @method('PATCH') @endif

                    <div class="form-group">
                        <label class="form-label">Topic name *</label>
                        <input type="text" name="name" class="form-input"
                               value="{{ old('name', $topic->name ?? '') }}"
                               placeholder="e.g. Science" required>
                    </div>

                    <div class="topic-field-grid">
                        <div class="form-group">
                            <label class="form-label">Emoji icon</label>
                            <input type="text" name="icon" class="form-input topic-icon-input"
                                   value="{{ old('icon', $topic->icon ?? '') }}"
                                   placeholder="🔬" maxlength="10">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Accent color</label>
                            <div class="color-input-row">
                                <input type="color" name="color"
                                       value="{{ old('color', $topic->color ?? '#185FA5') }}"
                                       class="color-picker">
                                <input type="text" name="color_text"
                                       value="{{ old('color', $topic->color ?? '#185FA5') }}"
                                       class="form-input" placeholder="#185FA5">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Topic image <span class="admin-muted-note">(optional — overrides emoji on bubble)</span></label>
                        <div class="drop-zone" id="dropZone">
                            <div class="drop-zone-icon">🖼️</div>
                            <p><strong>Drag & drop</strong> an image here</p>
                            <p>or click to browse &nbsp;·&nbsp; PNG, JPG, WEBP &nbsp;·&nbsp; max 2MB</p>
                            @if($topic && $topic->image)
                                <img src="{{ Storage::url($topic->image) }}" class="existing-topic-image" alt="{{ $topic->name }} image">
                            @endif
                            <img id="dropPreview" class="drop-preview">
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*" class="visually-hidden-file">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            {{ $topic ? 'Save changes' : 'Create topic' }}
                        </button>
                        <a href="{{ route('admin.topics.index') }}" class="btn-edit">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
