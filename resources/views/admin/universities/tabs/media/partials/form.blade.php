@php
    $v = fn($key, $default = '') => old($key, $media?->{$key} ?? $default);
@endphp

@if ($errors->any())
    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
        <div class="font-semibold mb-1">Please fix the errors:</div>
        <ul class="list-disc pl-5 text-sm">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Type <span class="text-rose-500">*</span></label>
        <select name="type"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
            <option value="image" @selected($v('type', 'image') === 'image')>Image</option>
            <option value="document" @selected($v('type') === 'document')>Document</option>
        </select>
    </div>

    <div class="flex items-end gap-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300"
                @checked((bool) old('is_active', $media?->is_active ?? true))>
            <span class="text-sm font-medium">Active</span>
        </label>
    </div>

    <div>
        <label class="text-sm font-medium">Title</label>
        <input name="title" value="{{ $v('title') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>

    <div>
        <label class="text-sm font-medium">Caption</label>
        <input name="caption" value="{{ $v('caption') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>

    <div>
        <label class="text-sm font-medium">{{ $media ? 'Replace File (optional)' : 'File *' }}</label>
        <input type="file" name="file" class="mt-1 block w-full text-sm" />
        <div class="text-xs text-slate-500 mt-1">Max 8MB</div>
    </div>

    <div>
        <label class="text-sm font-medium">Sort Order</label>
        <input type="number" name="sort_order" value="{{ $v('sort_order', 0) }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
</div>

@if ($media)
    <div class="border border-slate-200 rounded-2xl overflow-hidden">
        <div class="p-4 flex items-center justify-between">
            <div class="text-sm font-medium">Current File</div>
            <div class="text-xs text-slate-500">{{ $media->mime_type ?? '' }} •
                {{ $media->file_size ? number_format($media->file_size / 1024, 1) . ' KB' : '' }}</div>
        </div>
        <div class="bg-slate-50 border-t border-slate-200">
            @if ($media->type === 'image')
                <img src="{{ asset('storage/' . $media->file_path) }}" class="w-full h-56 object-cover" alt="">
            @else
                <div class="p-6 text-sm text-slate-700 break-all">{{ $media->file_path }}</div>
            @endif
        </div>
    </div>
@endif
