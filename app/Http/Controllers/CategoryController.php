<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoryController
 *
 * This class handles the CRUD operations for the Category model.
 * It allows users to view, add, edit, delete, and restore categories.
 */
class CategoryController extends Controller
{
    /**
     * Create a new CategoryController instance.
     * Apply the 'auth' middleware to require authentication for all methods.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all categories and trashed categories.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function AllCat()
    {
        // Retrieve all categories and trashed categories from the database
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->paginate(5);

        // Return the categories to the view
        return view('admin.category.index', compact('categories', 'trashCat'));
    }

    /**
     * Add a new category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AddCat(Request $request)
    {
        // Validate the user input
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ], [
            'category_name.required' => 'Please input the category name.',
            'category_name.max' => 'Category name must be less than 255 characters.',
        ]);

        // Insert the new category into the database
        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        // Redirect back with success message
        return Redirect()->back()->with('success', 'Category inserted successfully.');
    }

    /**
     * Edit an existing category.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Edit($id)
    {
        // Find the category by ID
        $categories = Category::find($id);

        // Return the category to the view for editing
        return view('admin.category.edit', compact('categories'));
    }

    /**
     * Update an existing category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Update(Request $request, $id)
    {
        // Update the category in the database
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        // Redirect to the category list with success message
        return Redirect()->route('category.all')->with('success', 'Category updated successfully.');
    }

    /**
     * Soft delete a category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function SoftDelete($id)
    {
        // Soft delete the category from the database
        $delete = Category::find($id)->delete();

        // Redirect back with success message
        return Redirect()->back()->with('success', 'Category soft deleted successfully.');
    }

    /**
     * Restore a soft deleted category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Restore($id)
    {
        // Restore the soft deleted category in the database
        $delete = Category::withTrashed()->find($id)->restore();

        // Redirect back with success message
        return Redirect()->back()->with('success', 'Category restored successfully.');
    }
}
