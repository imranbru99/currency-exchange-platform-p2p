<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Forum;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

	public function index(){
		$pageTitle = 'Category';
        $forums = Forum::where('status', 1)->get();
		$categories = Category::with('forum')->latest()->paginate(getPaginate());
		return view('admin.category.index', compact('pageTitle', 'categories', 'forums'));
	}

	public function add(Request $request){

		$request->validate([
			'forum' => 'required|exists:forums,id',
			'name' => 'required|string|max:191|unique:categories',
			'icon' => 'required|string|max:250',
			'status' => 'sometimes|in:on',
            'des' => 'required|string|max:60000',
		]);

        $new = new Category();
		$new->forum_id = $request->forum;
		$new->name = $request->name;
		$new->icon = $request->icon;
		$new->description = $request->des;
		$new->status = isset($request->status) ? 1 : 0;
		$new->save();

        $notify[] = ['success', 'Category created successfully'];
        return back()->withNotify($notify);
	}

	public function update(Request $request){

		$request->validate([
            'forum' => 'required|exists:forums,id',
			'id' => 'required|exists:categories,id',
			'name' => ['required', 'string', 'max:191', Rule::unique('categories')->ignore($request->id)],
			'icon' => 'required|string|max:250',
			'status' => 'sometimes|in:on',
            'des' => 'required|string|max:60000',
		]);

		$category = Category::find($request->id);
        $category->forum_id = $request->forum;
		$category->name = $request->name;
		$category->icon = $request->icon;
        $category->description = $request->des;
		$category->status = isset($request->status) ? 1 : 0;
		$category->save();

		$notify[] = ['success', 'Category updated successfully'];
        return back()->withNotify($notify);
	}

	public function subCategory(){
		$pageTitle = 'Sub Category';
		$categories = Category::latest()->get();
		$subCategories = SubCategory::latest()->with('category')->paginate(getPaginate());
		return view('admin.category.sub_category', compact('pageTitle', 'subCategories', 'categories'));
	}

	public function addSubCategory(Request $request){

		$request->validate([
			'category' => 'required|exists:categories,id',
			'name' => 'required|string|max:191|unique:sub_categories',
            'status' => 'sometimes|in:on',
		]);

		$new = new SubCategory();
		$new->category_id = $request->category;
		$new->name = $request->name;
		$new->status = isset($request->status) ? 1 : 0;
		$new->save();

		$notify[] = ['success', 'Sub category created successfully'];
        return back()->withNotify($notify);
	}

	public function updateSubCategory(Request $request){

		$request->validate([
			'id' => 'required|exists:sub_categories,id',
			'category' => 'required|exists:categories,id',
			'name' => ['required', 'string', 'max:191', Rule::unique('sub_categories')->ignore($request->id)],
            'status' => 'sometimes|in:on',
		]);

		$row = SubCategory::find($request->id);
		$row->category_id = $request->category;
		$row->name = $request->name;
        $row->status = isset($request->status) ? 1 : 0;
		$row->save();

		$notify[] = ['success', 'Sub category updated successfully'];
        return back()->withNotify($notify);
	}





}


