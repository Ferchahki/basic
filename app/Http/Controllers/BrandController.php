<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;
use Auth;

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
        $brand = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brand'));
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
            'brand_name' => 'required|unique:brands|min:255',
            'brand_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],
        [
            'brand_name.required' => 'Please input the brand name.',
            'brand_image.min' => 'Please input the brand name.',
        ]);



        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);

            // You may want to save the image path to your database here if needed.
            Brand::insert([
                'brand_name' => $request->brand_name,
                'brand_image' => $image,
                'created_at' => Carbon::now()
            ]);
        }



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
}
