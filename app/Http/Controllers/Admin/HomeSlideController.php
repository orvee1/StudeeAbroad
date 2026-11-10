<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSlideController extends Controller
{
    public function index()
    {
        $slides = HomeSlide::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.home_slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.home_slides.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(true));
        $image = $data['image'];
        unset($data['image']);

        $data['image_path'] = $image->store('home-slides', 'public');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        HomeSlide::create($data);

        return redirect()->route('home_slides.index')->with('success', 'Home slide added successfully.');
    }

    public function edit(HomeSlide $home_slide)
    {
        return view('admin.home_slides.edit', ['slide' => $home_slide]);
    }

    public function update(Request $request, HomeSlide $home_slide)
    {
        $data = $request->validate($this->rules(false));
        $oldImagePath = $home_slide->image_path;
        $newImagePath = null;

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('home-slides', 'public');
            $data['image_path'] = $newImagePath;
        }

        unset($data['image']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        $home_slide->update($data);

        if ($newImagePath && $oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()->route('home_slides.index')->with('success', 'Home slide updated successfully.');
    }

    public function destroy(HomeSlide $home_slide)
    {
        if ($home_slide->image_path) {
            Storage::disk('public')->delete($home_slide->image_path);
        }

        $home_slide->delete();

        return redirect()->route('home_slides.index')->with('success', 'Home slide deleted.');
    }

    private function rules(bool $imageRequired): array
    {
        return [
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:1000'],
            'button_text' => ['nullable', 'required_with:button_url', 'string', 'max:50'],
            'button_url' => ['nullable', 'required_with:button_text', 'url', 'max:255'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
