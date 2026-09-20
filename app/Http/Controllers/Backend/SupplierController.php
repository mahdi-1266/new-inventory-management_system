<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
  /* ----- Getting the data from db ----- */
  public function AllSupplier(){
    $supplier = Supplier::latest()->get();
    return view('admin.backend.supplier.all_supplier', compact('supplier'));
  }


  /* ----- Creating the blade file ----- */
  public function AddSupplier(){
    return view('admin.backend.supplier.add_supplier');
  }


  /* -----Inserting the data into table & db ----- */
  public function StoreSupplier(Request $request){

    // Validating the inputs fields
    $validation = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:50',
      'phone' => 'nullable|string|max:25',
      'address' => 'required|string|max:50',
    ]);


    /* ----- Inserting the data into the db ----- */
    Supplier::create([
      'name' => $validation['name'],
      'email' => $validation['email'],
      'phone' => $validation['phone'],
      'address' => $validation['address'],
    ]);

    /* ----- Displaying the message ----- */
    $notification = array([
      'message' => 'Supplier Is Inserted Successfully',
      'alert-type' => 'success'
    ]);

    return redirect()->route('all.supplier')->with($notification);
  }


  /* ----- Editting the data ----- */
  public function EditSupplier($id){
    $supplier = Supplier::find($id);
    return view('admin.backend.supplier.edit_supplier', compact('supplier'));
  }


  /* ----- Updating the data ----- */
  public function UpdateSupplier(Request $request){
    $supplier_id = $request->id;

    $validation = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'nullable|string|max:25',
      'address' => 'required|string|max:50',
    ]);


    Supplier::find($supplier_id)->update([
      'name' => $validation['name'],
      'email' => $validation['email'],
      'phone' => $validation['phone'],
      'address' => $validation['address'],
    ]);

    /* ----- Displaying the notification ----- */
    $notification = array([
      'message' => 'Supplier has been updated successfully',
      'alert-type' => 'success'
    ]);

    return redirect()->route('all.supplier')->with($notification);
  }


  /* ----- Delete the data ----- */
  public function DeleteSupplier($id){
    Supplier::find($id)->delete();

    $notification = array([
      'message' => 'Supplier has been deleted successfully',
      'alert-type' => 'success'
    ]);
    return redirect()->back()->with($notification);
  }

}