<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ $topic ? 'Edit' : 'New' }} Topic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('admin.partials.style')
</head>
<body>
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

        <div class="acard" style="max-width:560px">
            <div class="acard-header"><h2>Topic details</h2></div>
            <div style="padding:20px">
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

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                        <div class="form-group">
                            <label class="form-label">Emoji icon</label>
                            <input type="text" name="icon" class="form-input"
                                   value="{{ old('icon', $topic->icon ?? '') }}"
                                   placeholder="🔬" maxlength="10"
                                   style="font-size:20px;text-align:center">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Accent color</label>
                            <div style="display:flex;gap:8px;align-items:center">
                                <input type="color" name="color"
                                       value="{{ old('color', $topic->color ?? '#185FA5') }}"
                                       style="width:42px;height:36px;border-radius:8px;border:0.5px solid rgba(255,255,255,0.15);background:none;cursor:pointer;padding:2px;flex-shrink:0">
                                <input type="text" name="color_text"
                                       value="{{ old('color', $topic->color ?? '#185FA5') }}"
                                       class="form-input" placeholder="#185FA5">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Topic image <span style="color:rgba(255,255,255,0.3)">(optional — overrides emoji on bubble)</span></label>
                        <div class="drop-zone" id="dropZone">
                            <div class="drop-zone-icon">🖼️</div>
                            <p><strong>Drag & drop</strong> an image here</p>
                            <p>or click to browse &nbsp;·&nbsp; PNG, JPG, WEBP &nbsp;·&nbsp; max 2MB</p>
                            @if($topic && $topic->image)
                                <img src="{{ Storage::url($topic->image) }}"
                                     style="max-width:120px;max-height:80px;border-radius:8px;margin:10px auto 0;display:block">
                            @endif
                            <img id="dropPreview" class="drop-preview">
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*" style="display:none">
                    </div>

                    <div style="display:flex;gap:10px;margin-top:8px">
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
<script>
    const dropZone   = document.getElementById('dropZone');
    const imageInput = document.getElementById('imageInput');
    const preview    = document.getElementById('dropPreview');

    dropZone.addEventListener('click', () => imageInput.click());
    dropZone.addEventListener('dragover',  e => { e.preventDefault(); dropZone.classList.add('dragover'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault(); dropZone.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) { showPreview(file); setFile(file); }
    });
    imageInput.addEventListener('change', () => {
        if (imageInput.files[0]) showPreview(imageInput.files[0]);
    });
    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(file);
    }
    function setFile(file) {
        const dt = new DataTransfer();
        dt.items.add(file);
        imageInput.files = dt.files;
    }
</script>
</body>
</html>
