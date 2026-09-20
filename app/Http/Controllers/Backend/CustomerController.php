<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
  // Customer getting data from db
  public function AllCustomer(){
    $customer = Customer::latest()->get();
    return view('admin.backend.customer.all_customer', compact('customer'));
  }


  // Adding the add blade file
  public function AddCustomer(){
    return view('admin.backend.customer.add_customer');
  }


  // storing the data into db
  public function StoreCustomer(Request $request){

    // validating the data
    $validation = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:50',
      'phone' => 'required|string|max:25',
      'address' => 'required|string|max:50',
    ]);


    // inserting the data into db
    Customer::create([
      'name' => $validation['name'],
      'email' => $validation['email'],
      'phone' => $validation['phone'],
      'address' => $validation['address']
    ]);

    // Displaying notification
    $notification = array([
      'message' => 'Customer is inserted successfully',
      'alert-type' => 'success'
    ]);

    return redirect()->route('all.customer')->with($notification);
  }

  // creating the edit blade
  public function EditCustomer($id){
    $customer = Customer::find($id);
    return view('admin.backend.customer.edit_customer', compact('customer'));
  }


  // updating the customer
  public function UpdateCustomer(Request $request){
    $customer_id = $request->id;

    // validating the data
    $validation = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:50',
      'phone' => 'required|string|max:25',
      'address' => 'required|string|max:50',
    ]);


    // inserting the data into db
    Customer::find($customer_id)->update([
      'name' => $validation['name'],
      'email' => $validation['email'],
      'phone' => $validation['phone'],
      'address' => $validation['address']
    ]);

    /* ----- Displaying the notification ----- */
    $notification = array([
      'message' => 'Customer has been updated successfully',
      'alert-type' => 'success'
    ]);

    return redirect()->route('all.customer')->with($notification);
  }


  // deleting the customer
  public function DeleteCustomer($id){
    Customer::find($id)->delete();
    $notification = array([
      'message' => 'Customer has been deleted successfully',
      'alert-type' => 'success'
    ]);
    return redirect()->route('all.customer')->with($notification);
  }
}