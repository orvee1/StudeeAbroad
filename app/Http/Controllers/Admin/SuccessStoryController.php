<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use App\Models\SuccessStoryMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SuccessStoryController extends Controller
{
    private const EVIDENCE_FIELDS = [
        'passport_images' => 'passport',
        'visa_images' => 'visa',
        'admission_images' => 'admission',
    ];

    public function index(Request $request): View
    {
        $q = trim((string) $request->get('q', ''));
        $isActive = $request->get('is_active');

        $query = SuccessStory::query()->withCount('media');

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('destination', 'like', "%{$q}%")
                    ->orWhere('from', 'like', "%{$q}%");
            });
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where('is_active', (bool) $isActive);
        }

        $stories = $query
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(20)
            ->appends($request->query());

        return view('admin.success_stories.index', compact('stories', 'q', 'isActive'));
    }

    public function create(): View
    {
        return view('admin.success_stories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->storyRules());
        $data = $this->removeUploadFields($data);
        $data['user_id'] = $request->user()->id;
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('success-stories/photos', 'public');
        }

        $story = SuccessStory::create($data);
        $this->storeEvidence($story, $request);

        return redirect()->route('success_stories.edit', $story)->with('success', 'Success story created.');
    }

    public function edit(SuccessStory $success_story): View
    {
        $success_story->load(['media' => fn ($query) => $query->orderBy('sort_order')->orderBy('id')]);

        return view('admin.success_stories.edit', ['story' => $success_story]);
    }

    public function update(Request $request, SuccessStory $success_story)
    {
        $data = $request->validate($this->storyRules());
        $data = $this->removeUploadFields($data);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? $success_story->sort_order);

        if ($request->hasFile('photo')) {
            if ($success_story->photo_path) {
                Storage::disk('public')->delete($success_story->photo_path);
            }

            $data['photo_path'] = $request->file('photo')->store('success-stories/photos', 'public');
        }

        $success_story->update($data);
        $this->storeEvidence($success_story, $request);

        return redirect()->route('success_stories.edit', $success_story)->with('success', 'Success story updated.');
    }

    public function moderate(Request $request, SuccessStory $success_story)
    {
        $data = $request->validate([
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        $success_story->update([
            'sort_order' => $data['sort_order'] ?? $success_story->sort_order,
            'is_active' => (bool) $data['is_active'],
        ]);

        return back()->with('success', 'Story visibility and order updated.');
    }

    public function mediaPreview(SuccessStory $success_story, SuccessStoryMedia $media): BinaryFileResponse
    {
        abort_unless((int) $media->success_story_id === (int) $success_story->id, 404);
        abort_unless(Storage::disk('local')->exists($media->file_path), 404);

        return response()->file(Storage::disk('local')->path($media->file_path), [
            'Content-Type' => $media->mime_type,
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function destroyMedia(SuccessStory $success_story, SuccessStoryMedia $media)
    {
        abort_unless((int) $media->success_story_id === (int) $success_story->id, 404);

        Storage::disk('local')->delete($media->file_path);
        $media->delete();

        return redirect()->route('success_stories.edit', $success_story)->with('success', 'Document image removed.');
    }

    public function destroy(SuccessStory $success_story)
    {
        foreach ($success_story->media as $media) {
            Storage::disk('local')->delete($media->file_path);
            $media->delete();
        }

        if ($success_story->photo_path) {
            Storage::disk('public')->delete($success_story->photo_path);
        }

        $success_story->delete();

        return back()->with('success', 'Story and its uploaded images deleted.');
    }

    private function storyRules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'from' => ['nullable', 'string', 'max:255'],
            'destination' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:50'],
            'score' => ['nullable', 'string', 'max:50'],
            'year' => ['nullable', 'string', 'max:10'],
            'story' => ['required', 'string', 'max:20000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'confirm_publication' => ['required', 'accepted'],
        ];

        foreach (array_keys(self::EVIDENCE_FIELDS) as $field) {
            $rules[$field] = ['nullable', 'array', 'max:4'];
            $rules[$field . '.*'] = ['image', 'mimes:jpg,jpeg,png,webp', 'max:8192'];
        }

        return $rules;
    }

    private function removeUploadFields(array $data): array
    {
        unset($data['photo'], $data['confirm_publication']);

        foreach (array_keys(self::EVIDENCE_FIELDS) as $field) {
            unset($data[$field]);
        }

        return $data;
    }

    private function storeEvidence(SuccessStory $story, Request $request): void
    {
        foreach (self::EVIDENCE_FIELDS as $field => $type) {
            foreach ($request->file($field, []) as $file) {
                $path = $file->store('success-stories/evidence', 'local');

                $story->media()->create([
                    'type' => $type,
                    'caption' => match ($type) {
                        'passport' => 'Passport',
                        'visa' => 'Visa',
                        'admission' => 'University admission',
                    },
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType() ?: 'image/jpeg',
                    'file_size' => $file->getSize(),
                    'is_public' => true,
                ]);
            }
        }
    }
}
