<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagsResource;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{
    public function tags()
    {
        // обнуляється кеш тут - App\Observers;
        return TagsResource::collection(Cache::remember('api_tags', config('api.ttl'), function() {
            return Tag::where('parent_id', null)
                ->where('status', Tag::VISIBLE)
                ->get();
        }));
    }
}
