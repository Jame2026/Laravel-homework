<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // // raw db
        // $categories = DB::select("SELECT * FROM categories");

        ////Query Builder
        // $categories = DB::table('categories')->get();

        ////Eloquent 

        $categories = Category::orderBy('id', 'desc')->get();

        return view('categories.list', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store()
    {
        Category::create(
            [
                'name' => request()->name,
                'dec' => request()->dec
            ]
        );
        return redirect('/categories');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // dd(request()->all());
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'dec' => $request->dec,
        ]);

        return redirect('/categories');
    }
}
