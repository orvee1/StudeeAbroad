<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuccessStoryController extends Controller
{
    public function index()
    {
        $stories = SuccessStory::query()
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->paginate(10);

        return view('student.success_stories.index', compact('stories'));
    }

    public function create()
    {
        return view('student.success_stories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'from'        => ['nullable', 'string', 'max:255'],
            'destination' => ['nullable', 'string', 'max:255'],
            'badge'       => ['nullable', 'string', 'max:50'],
            'score'       => ['nullable', 'string', 'max:50'],
            'year'        => ['nullable', 'string', 'max:10'],
            'story'       => ['required', 'string'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['user_id'] = auth()->id();

        $data['is_active']  = false;
        $data['sort_order'] = 0;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('success-stories/photos', 'public');
        }

        SuccessStory::create($data);

        return redirect()->route('student.success_stories.index')->with('success', 'Story submitted. Waiting for approval.');
    }

    public function edit(SuccessStory $success_story)
    {
        $this->authorize('update', $success_story);

        return view('student.success_stories.edit', ['story' => $success_story]);
    }

    public function update(Request $request, SuccessStory $success_story)
    {
        $this->authorize('update', $success_story);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'from'        => ['nullable', 'string', 'max:255'],
            'destination' => ['nullable', 'string', 'max:255'],
            'badge'       => ['nullable', 'string', 'max:50'],
            'score'       => ['nullable', 'string', 'max:50'],
            'year'        => ['nullable', 'string', 'max:10'],
            'story'       => ['required', 'string'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['is_active'] = false;

        if ($request->hasFile('photo')) {
            if ($success_story->photo_path && Storage::disk('public')->exists($success_story->photo_path)) {
                Storage::disk('public')->delete($success_story->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('success-stories/photos', 'public');
        }

        $success_story->update($data);

        return redirect()->route('student.success_stories.index')->with('success', 'Story updated. Waiting for approval.');
    }
}
