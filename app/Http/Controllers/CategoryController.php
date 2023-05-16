<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $categoriesCollection = new Collection($categories, new CategoryTransformer());
        $data = fractal($categoriesCollection)->toArray();
        return response()->json($data);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $categoryItem = new Item($category, new CategoryTransformer());
        $data = fractal($categoryItem)->toArray();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
        ]);

        $categoryItem = new Item($category, new CategoryTransformer());
        $data = fractal($categoryItem)->toArray();
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        $category->name = $request->input('name');
        $category->save();

        $categoryItem = new Item($category, new CategoryTransformer());
        $data = fractal($categoryItem)->toArray();
        return response()->json($data);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }
}
