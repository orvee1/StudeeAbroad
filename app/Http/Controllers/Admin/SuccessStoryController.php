<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;

class SuccessStoryController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim((string) $request->get('q', ''));
        $isActive = $request->get('is_active');

        $query = SuccessStory::query();

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

    // inline update: sort_order + is_active
    public function update(Request $request, SuccessStory $success_story)
    {
        $data = $request->validate([
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $success_story->update([
            'sort_order' => $data['sort_order'] ?? $success_story->sort_order,
            'is_active'  => array_key_exists('is_active', $data) ? (bool) $data['is_active'] : $success_story->is_active,
        ]);

        return back()->with('success', 'Updated successfully.');
    }

    public function destroy(SuccessStory $success_story)
    {
        $success_story->delete();
        return back()->with('success', 'Deleted successfully.');
    }
}
