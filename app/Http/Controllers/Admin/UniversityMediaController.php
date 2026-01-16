<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UniversityMediaStoreRequest;
use App\Http\Requests\Admin\UniversityMediaUpdateRequest;
use App\Models\University;
use App\Models\UniversityMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UniversityMediaController extends Controller
{
    public function index(University $university, Request $request)
    {
        $type     = $request->get('type'); // image|document|null
        $isActive = $request->get('is_active');

        $query = UniversityMedia::query()->where('university_id', $university->id);

        if ($type !== null && $type !== '') {
            $query->where('type', $type);
        }
        if ($isActive !== null && $isActive !== '') {
            $query->where('is_active', (bool) $isActive);
        }

        $media = $query->orderBy('sort_order')->orderByDesc('id')->paginate(20)->withQueryString();

        return view('admin.universities.tabs.media.index', compact('university', 'media', 'type', 'isActive'));
    }

    public function create(University $university)
    {
        return view('admin.universities.tabs.media.create', compact('university'));
    }

    public function store(University $university, UniversityMediaStoreRequest $request)
    {
        $data = $request->validated();

        $file = $request->file('file');

        $path = $file->store("universities/{$university->id}/media", 'public');

        $record = [
            'university_id' => $university->id,
            'type'          => $data['type'],
            'title'         => $data['title'] ?? null,
            'caption'       => $data['caption'] ?? null,
            'file_path'     => $path,
            'mime_type'     => $file->getMimeType(),
            'file_size'     => $file->getSize(),
            'sort_order'    => (int) ($data['sort_order'] ?? 0),
            'is_active'     => (bool) ($data['is_active'] ?? false),
        ];

        UniversityMedia::create($record);

        return redirect()
            ->route('universities.media.index', $university)
            ->with('success', 'Media uploaded successfully.');
    }

    public function edit(University $university, UniversityMedia $media)
    {
        abort_unless($media->university_id === $university->id, 404);

        return view('admin.universities.tabs.media.edit', compact('university', 'media'));
    }

    public function update(University $university, UniversityMedia $media, UniversityMediaUpdateRequest $request)
    {
        abort_unless($media->university_id === $university->id, 404);

        $data = $request->validated();

        $update = [
            'type'       => $data['type'],
            'title'      => $data['title'] ?? null,
            'caption'    => $data['caption'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active'  => (bool) ($data['is_active'] ?? false),
        ];

        if ($request->hasFile('file')) {
            if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }

            $file = $request->file('file');
            $path = $file->store("universities/{$university->id}/media", 'public');

            $update['file_path'] = $path;
            $update['mime_type'] = $file->getMimeType();
            $update['file_size'] = $file->getSize();
        }

        $media->update($update);

        return redirect()
            ->route('universities.media.index', $university)
            ->with('success', 'Media updated successfully.');
    }

    public function destroy(University $university, UniversityMedia $media)
    {
        abort_unless($media->university_id === $university->id, 404);

        // soft delete; file keep (or delete now if you want)
        $media->delete();

        return redirect()
            ->route('universities.media.index', $university)
            ->with('success', 'Media deleted successfully.');
    }
}
