<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoryDesc' => 'required|string|max:255',
        ]);

        $category = new Category;
        $category->desc = $validated['categoryDesc'];
        $category->save();

        return redirect()->route('transactions.create')->with([
            'success' => 'Categoria criada com sucesso!',
            'openCategoryModal' => true,
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::all();

        return view('transactions', [
            'editCategory' => $category,
            'categories' => $categories,
            'openCategoryModal' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'categoryDesc' => 'required|string|max:255',
        ]);
    
        $category->desc = $request->input('categoryDesc');
        $category->save();
    
        return redirect()->route('transactions.create')->with([
            'success' => 'Categoria atualizada com sucesso!',
            'openCategoryModal' => true,
        ]);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('transactions.create')->with([
            'success' => 'Categoria excluído com sucesso!',
            'openCategoryModal' => true,
        ]);
    }
}
