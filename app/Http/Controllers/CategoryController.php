<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateUpdateCategoryRequest;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Successfully',
            'data' => Category::paginate(5)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUpdateCategoryRequest $request)
    {
        DB::beginTransaction();

        try {
            $category = Category::create($request->all());
        } catch(Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            'status' => true,
            'message' => 'Successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateUpdateCategoryRequest $request, Category $category)
    {
        DB::beginTransaction();

        try {
            $category->update($request->all());
        } catch(Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Category Updated',
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();

        try {
            $category->delete();
        } catch(Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted'
        ], 200);
    }
}
