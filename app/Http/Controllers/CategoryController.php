<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show']]);
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = Category::latest()->paginate(5);

        return view('category.index',compact('categories'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
        ]);
    
        Category::create($request->all());
    
        return redirect()->route('categories.index')->with('success','Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('category.show',compact('category'));
    }

    public function edit(Category $category)
    {
        return view('category.edit',compact('category'));
    }

    public function update(Request $request, Category $category)
    {
         request()->validate([
            'name' => 'required',
        ]);
    
        $category->update($request->all());
    
        return redirect()->route('categories.index')->with('success','Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
    
        return redirect()->route('categories.index')->with('success','Category deleted successfully');
    }
}
