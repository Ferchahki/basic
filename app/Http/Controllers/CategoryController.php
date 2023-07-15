<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function AllCat(){

        // $categories = DB::table('categories')
        //         ->join('users','categories.user_id','users.id')
        //         ->select('categories.*','users.name')
        //         ->latest()->paginate(5);
        $categories = Category::latest()->paginate(5);
        $trashCat=Category::onlyTrashed()->paginate(5);

        return view('admin.category.index',compact('categories','trashCat'));

    }

    public function AddCat(Request $request){
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',

        ],   // validation form required
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category Less Then 255Chars',
        ]);

        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        // Approach 1: Eloquent ORM
        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();
        //Approach 2: Query Builder
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success','Category Inserted Successfull');

    }

    public function Edit($id){

        //dd($id);
        $categories=Category::find($id);

        //dd($categories);

        return view('admin.category.edit',compact('categories'));

    }

    public function Update(Request $request ,$id){

        //  elaquant ORM
         $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);
        // sql db
       // $data = array();
       // $data['category_name'] = $request->category_name;
       //  $data['user_id'] = Auth::user()->id;
       // DB::table('categories')->where('id',$id)->update($data);
        return Redirect()->route('category.all')->with('success','Category Updated Successfull');

    }
    // Methode softdelete
    public function SoftDelete($id){
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success','Category Soft Delete Successfully');
    }

    public function Restore($id){

        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success','Category Restore Successfully');

    }


}
