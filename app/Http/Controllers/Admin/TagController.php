<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\LogAction;
use App\Models\Tag;
use App\Models\User;
use Auth;
use Illuminate\Validation\ValidationException;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tags = Tag::paginate(100);
        return view('tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $tags = Tag::whereNull('parent_id');
        $statuses = User::getListStatus();
        return view('tag.create', compact( 'tags', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(TagRequest $request)
    {
        $data = $request->validated();
        $tag = new Tag();
        $tag->saveModel($data);
        return redirect()->route('tag.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Tag $tag)
    {
        $tags = Tag::whereNull('parent_id')->where('id', '!=' , $tag->id)->get();
        $statuses = Tag::$listStatus;
        return view('tag.edit', compact( 'tag', 'tags', 'statuses'));
    }

    public function history(Tag $tag)
    {
        if(Auth::id() == User::ADMIN_ID){
            $histories = LogAction::where('model_id', $tag->id)->where('model', Tag::class)->orderByDesc('id')->paginate(10);
            $title = 'Тег: '. $tag->name;
            $route = route('tag.index');
            return view('admin.history', compact('histories', 'title', 'route'));
        }
        return redirect()->route('user.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagRequest $request, $id)
    {
        $data = $request->validated();
        $tag = Tag::findOrFail($id);
        $tag->saveModel($data);
        return redirect()->route('tag.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tag.index');
    }
}
