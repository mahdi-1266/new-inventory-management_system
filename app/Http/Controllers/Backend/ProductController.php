<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Models\Brand;
use App\Models\WareHouse;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
  // Getting the data from db
  public function AllCategory(){
    $category = ProductCategory::latest()->get();
    return view('admin.backend.category.all_category', compact('category'));
  }


  // Inserting the data into db
  public function StoreCategory(Request $request){

    $validation = $request->validate([
      'category_name' => 'required|string|max:50'
    ]);

    ProductCategory::create([
      'category_name' => $validation['category_name'],
      'category_slug' => strtolower(str_replace(' ', '-', $validation['category_name']))
    ]);

    $notification = array(
      'message' => 'Product Category Added Successfully',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }


  public function EditCategory($id){
    $category = ProductCategory::find($id);
    return response()->json($category);
  }


  // updating the category
  public function UpdateCategory(Request $request){

    $category_id = $request->cat_id;

    $validation = $request->validate([
      'category_name' => 'required|string|max:50'
    ]);

    ProductCategory::find($category_id)->update([
      'category_name' => $validation['category_name'],
      'category_slug' => strtolower(str_replace(' ', '-', $validation['category_name']))
    ]);

    $notification = array(
      'message' => 'Product Category Updated Successfully',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }


  // deleting the category
  public function DeleteCategory($id){
    ProductCategory::find($id)->delete();

    $notification = array(
      'message' => 'Product Category Deleted Successfully',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }




  /* ------ All Products Controller Functions ------ */
  public function AllProduct(){
    $allData = Product::orderBy('id', 'desc')->get();
    return view('admin.backend.product.product_list', compact('allData'));
  }


  public function AddProduct(){

    // In add_product.blade.php, we gathered some data from other tables/models as below
    $categories = ProductCategory::all();
    $brands = Brand::all();
    $suppliers = Supplier::all();
    $warehouses = WareHouse::all();

    return view('admin.backend.product.add_product', compact('categories', 'brands', 'suppliers', 'warehouses'));
  }


  // Storing data into table
  public function StoreProduct(Request $request){

    // Inserting the data into tables
    $product = Product::create([
      'name' => $request->name,
      'code' => $request->code,
      'category_id' => $request->category_id,
      'brand_id' => $request->brand_id,
      'supplier_id' => $request->supplier_id,
      'warehouse_id' => $request->warehouse_id,
      'price' => $request->price,
      'stock_alert' => $request->stock_alert,
      'note' => $request->note,
      'product_qty' => $request->product_qty,
      'status' => $request->status,
      'created_at' => now(),
    ]);


    $product_id = $product->id;

    if ($request->hasFile('image')) {
      foreach($request->file('image') as $img){
        $manager = new ImageManager(new Driver());
        $image_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $imgs = $manager->decode($img);
        $imgs->resize(150, 150)->save(public_path('upload/product/'.$image_name));
        $save_url = 'upload/product/'.$image_name;


        ProductImage::create([
          'product_id' => $product_id,
          'image' => $save_url,
        ]);
      }
    }

    $notification = array([
      'message' => 'Product Is Added Successfully',
      'alert-type' => 'success',
    ]);
    return redirect()->route('all.product')->with($notification);
  }


  // Editting data
  public function EditProduct($id){
    $productIdEditData = Product::find($id);
    $categories = ProductCategory::all();
    $brands = Brand::all();
    $suppliers = Supplier::all();
    $warehouses = WareHouse::all();
    $multiImg = ProductImage::where('product_id', $id)->get();

    return view('admin.backend.product.edit_product', compact(
      'categories', 'brands', 'suppliers', 'warehouses', 'productIdEditData', 'multiImg'
    ));
  }


  public function UpdateProduct(Request $request){
    $product_id = $request->id;
    $product = Product::findOrFail($product_id);

    $product->name = $request->name;
    $product->code = $request->code;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;
    $product->price = $request->price;
    $product->stock_alert = $request->stock_alert;
    $product->note = $request->note;
    $product->warehouse_id = $request->warehouse_id;
    $product->supplier_id = $request->supplier_id;
    $product->product_qty = $request->product_qty;
    $product->status = $request->status;
    $product->save();

    if ($request->hasFile('image')) {
      foreach($request->file('image') as $img){
        $manager = new ImageManager(new Driver());
        $image_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $imgs = $manager->decode($img);
        $imgs->resize(150, 150)->save(public_path('upload/product/'.$image_name));
        $save_url = 'upload/product/'.$image_name;

        $product->images()->create([
          'image' => $save_url,
        ]);
      }
    }

    // Removing the image
    if($request->has('remove_image')){
      foreach($request->remove_image as $removeImageId){
        $img = ProductImage::find($removeImageId);
        $img_location = file_exists(public_path($img->image));

        if($img && $img_location){
          unlink(public_path($img->image));
          $img->delete();
        }
      }
    }

    $notification = array(
      'message' => 'Product Updated Successfully',
      'alert-type' => 'success'
    );
    return redirect()->route('all.product')->with($notification);
  }


  // Deleting the product
  public function DeleteProduct($id){
    $product = Product::findOrFail($id);

    $images = ProductImage::where('product_id', $id)->get();
    foreach ($images as $img) {
      $imagePath = public_path($img->image);
      if(file_exists($imagePath)){
        unlink($imagePath);
      }
    }

    // Deleting the image
    ProductImage::where('product_id', $id)->delete();

    // Deleting the product itself
    $product->delete();

    $notification = array([
      'message' => 'Product Is Deleted Successfully',
      'alert-type' => 'success',
    ]);
    return redirect()->back()->with($notification);
  }



  // Product details method
  public function DetailsProduct($id){
    $product = Product::findOrFail($id);
    return view('admin.backend.product.details_product', compact('product'));
  }
}