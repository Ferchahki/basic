<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Multipic;
use Illuminate\Support\Carbon;

class AboutController extends Controller
{
    public function HomeAbout(){
        $homeabout = About::latest()->get();
        return view('admin.home.index', compact('homeabout'));
    }

    public function AddAbout(){
        return view('admin.home.create');
    }

    public function StoreAbout(Request $request){

        About::insert([
            'title' => $request->title,
            'short_dis' => $request->short_dis,
            'long_dis' => $request->long_dis,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->route('home.about')->with('success','About Inserted Successfully');
    }


    public function EditAbout($id){
        $homeabout = About::find($id);
        return view('admin.home.edit',compact('homeabout'));
    }

    public function UpdateAbout(Request $request, $id){
        $update = About::find($id)->update([
            'title' => $request->title,
            'short_dis' => $request->short_dis,
            'long_dis' => $request->long_dis,

        ]);

        return Redirect()->route('home.about')->with('success','About Updated Successfully');
    }

    public function DeleteAbout($id){
        $delete = About::find($id)->Delete();
        return Redirect()->back()->with('success','About Deleted Successfully');
    }

    public function Portfolio(){
        $images = Multipic::all();
        return view('pages.portfolio',compact('images'));
    }



}
