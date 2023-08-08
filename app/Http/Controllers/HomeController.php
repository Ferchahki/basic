<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;
use Auth;

class HomeController extends Controller
{
    //
    public function HomeSlider(){

        $sliders=Slider::latest()->get();

        return view('admin.slider.index',compact('sliders'));

    }

    public function AddSlider(){
        return view('admin.slider.create');
    }

    public function StoreSlider(Request $request){

        $slider_image =  $request->file('image');



        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($slider_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/slider/';
        $last_img = $up_location.$img_name;
        //dd($last_img);
        $slider_image->move($up_location,$img_name);


        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->route('home.slider')->with('success','Slider Inserted Successfully');

    }
}
