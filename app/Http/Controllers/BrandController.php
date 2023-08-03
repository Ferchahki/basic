<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Multipic;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Auth;
use Intervention\Image\ImageManager;


/**
 * The BrandController class handles the CRUD operations related to the Brand model.
 * It ensures that only authenticated users can access the methods of the class.
 */
class BrandController extends Controller
{
    /**
     * Create a new BrandController instance.
     * Set the middleware for authentication.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a paginated list of brands.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new brand.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created brand in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|image|mimes:jpeg,png,jpg,gif',

        ],
        [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_image.min' => 'Brand Longer then 4 Characters',
        ]);

        $brand_image =  $request->file('brand_image');

        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        //$name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        //ImageManage::make($brand_image)->resize(300,200)->save('image/brand/'.$name_gen);
        // $last_img = 'image/brand/'.$name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);


    }

    /**
     * Display the specified brand.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified brand.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
        $brands = Brand::find($id);

        // Return the brand to the view for editing
        return view('admin.brand.edit', compact('brands'));
    }

    /**
     * Update the specified brand in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'brand_name' => 'required|min:4',

        ],
        [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_image.min' => 'Brand Longer then 4 Characters',
        ]);

        $old_image = $request->old_image;

        $brand_image =  $request->file('brand_image');

        if($brand_image){

        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        unlink($old_image);
        Brand::find($id)->update([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Brand Updated Successfully',
            'alert-type' => 'info'
        );

        return Redirect()->back()->with($notification);

        }else{
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now()
            ]);
            $notification = array(
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'warning'
            );

            return Redirect()->back()->with($notification);

        }

        return Redirect()->back();
    }

    /**
     * Remove the specified brand from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //

    }

    public function SoftDelete($id)
    {
        // Soft delete the Brand from the database
        $delete = Brand::find($id)->delete();
        // Redirect back with success message
        return Redirect()->back()->with('success', 'Brand  deleted successfully.');
    }

    // function Multi picture image all methods

    public function Multipic(){

        $images=Multipic::all();

        return view('admin.multipic.index',compact('images'));

    }

    public function StoreImage(Request $request) {

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ],
        [
            'brand_image.min' => 'Brand Longer then 4 Characters',
        ]);

        $brand_image =  $request->file('image');

        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/multi/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        //$images =  $request->file('image');

        Multipic::insert([
            'image' => $last_img,
            'created_at' => Carbon::now()
        ]);


        // end of the foreach
       return Redirect()->back()->with('success','Brand Inserted Successfully');

    }

}
