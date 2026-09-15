<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forum;
use Illuminate\Validation\Rule;

class ForumController extends Controller
{

    public function index(){
		$pageTitle = 'All Forum';
		$forums = Forum::latest()->paginate(getPaginate());
		return view('admin.forum.index', compact('pageTitle', 'forums'));
	}

    public function add(Request $request){

        $request->validate([
			'name' => 'required|string|max:191|unique:forums',
			'icon' => 'required|string|max:250',
			'status' => 'sometimes|in:on'
		]);

        $new = new Forum();
		$new->name = $request->name;
		$new->icon = $request->icon;
		$new->status = isset($request->status) ? 1 : 0;
		$new->save();

        $notify[] = ['success', 'Forum created successfully.'];
        return back()->withNotify($notify);
    }

    public function update(Request $request){

        $request->validate([
            'id' => 'required|exists:forums,id',
			'name' => ['required', 'string', 'max:191', Rule::unique('forums')->ignore($request->id)],
			'icon' => 'required|string|max:250',
			'status' => 'sometimes|in:on'
		]);

        $forum = Forum::find($request->id);
		$forum->name = $request->name;
		$forum->icon = $request->icon;
		$forum->status = isset($request->status) ? 1 : 0;
		$forum->save();

        $notify[] = ['success', 'Forum updated successfully.'];
        return back()->withNotify($notify);
    }


}
