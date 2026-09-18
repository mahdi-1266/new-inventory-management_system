<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BrandController extends Controller
{
  public function AllBrand(){

    // Getting the brand data from db
    $brand = Brand::latest()->get();
    return view('admin.backend.brand.all_brand', compact('brand'));
  }

  // Created the brand blade
  public function AddBrand(){
    return view('admin.backend.brand.add_brand');
  }

  // Storing the brand to the table and db
  public function StoreBrand(Request $request){
    if ($request->file('logo')) {
      // Inputs validations
      $request->validate([
        'name' => 'required|string|max:50',
        'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
      ]);

      // Uploading the logo image to the table
      $logo = $request->file('logo');
      $manager = new ImageManager(new Driver());
      $logo_name = hexdec(uniqid()).'.'.$logo->getClientOriginalExtension();
      $img = $manager->decode($logo);
      $img->resize(100, 90)->save(public_path('upload/brand/'.$logo_name));
      $save_url = 'upload/brand/'.$logo_name;

      // Saving the brand logo in the database
      Brand::create([
        'name' => $request->name,
        'logo' => $save_url
      ]);
    }

    // Displaying the success message after inserting the brand
    $notification = array(
				'message' => 'Brand Inserted Successfully',
				'alert-type' => 'success'
			);
		return redirect()->route('all.brand')->with($notification);
  }


  // Editting the brand
  public function EditBrand($id){
    $brand = Brand::find($id);
    return view('admin.backend.brand.edit_brand', compact('brand'));
  }

  // Updating the brand
  public function UpdateBrand(Request $request){

    // Validating the inputs fields
    $request->validate([
      'name' => 'string|max:255',
      'logo' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);


    // taking the brand id
    $brand_id = $request->id;
    $brand = Brand::find($brand_id);

    if ($request->file('logo')) {
      $logo = $request->file('logo');
      $manager = new ImageManager(new Driver());
      $logo_name = hexdec(uniqid()).'.'.$logo->getClientOriginalExtension();
      $img = $manager->decode($logo);
      $img->resize(100, 90)->save(public_path('upload/brand/'.$logo_name));
      $save_url = 'upload/brand/'.$logo_name;

      // Removing the old logo
      if(file_exists(public_path($brand->logo))){
        unlink(public_path($brand->logo));
      }

      Brand::find($brand_id)->update([
        'name' => $request->name,
        'logo' => $save_url,
      ]);
    
      $notification = array([
        'message' => 'The brand has been updated with logo successfully',
        'alert-type' => 'success',
      ]);
      return redirect()->route('all.brand')->with($notification);  
    } else{
      Brand::find($brand_id)->update([
        'name' => $request->name
      ]);

      $notification = array([
        'message' => 'The brand has been updated without logo successfully',
        'alert-type' => 'success',
      ]);

      return redirect()->route('all.brand')->with($notification);
    }
  }


  // Deleting the brand
  public function DeleteBrand($id){
    $brand = Brand::find($id);
    $logo = $brand->logo;
    unlink($logo);

    Brand::find($id)->delete();
    $notification = array([
      'message' => 'The brand has been deleted successfully',
      'alert-type' => 'success',
    ]);
    return redirect()->back()->with($notification);
  }
}