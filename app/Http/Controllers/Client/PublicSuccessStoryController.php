<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use App\Models\SuccessStoryMedia;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

class PublicSuccessStoryController extends Controller
{
    public function show(SuccessStory $success_story): View
    {
        abort_unless($success_story->is_active, 404);

        $success_story->load([
            'user:id,profile_photo_path,role',
            'media' => fn ($query) => $query->where('is_public', true)->orderBy('sort_order')->orderBy('id'),
        ]);

        return view('client.success_stories.show', ['story' => $success_story]);
    }

    public function media(SuccessStory $success_story, SuccessStoryMedia $media): BinaryFileResponse
    {
        abort_unless(
            $success_story->is_active
                && (int) $media->success_story_id === (int) $success_story->id
                && $media->is_public,
            404
        );

        abort_unless(Storage::disk('local')->exists($media->file_path), 404);

        return response()->file(Storage::disk('local')->path($media->file_path), [
            'Content-Type' => $media->mime_type,
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
