<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WareHouse;

class WareHouseController extends Controller
{
  // Getting the data from the db
  public function AllWareHouses(){
    $warehouse = WareHouse::latest()->get();
    return view('admin.backend.warehouse.all_warehouse', compact('warehouse'));
  }

  // Add WareHouse
  public function AddWareHouse(){
    return view('admin.backend.warehouse.add_warehouse');
  }

  
  // Store WareHouse
  public function StoreWareHouse(Request $request){

    // Validating the inputs fields
    $validation = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'nullable|string|max:25',
      'city' => 'nullable|string|max:100',
    ]);

    // Inserting the data into the db
    WareHouse::create([
      'name' => $validation['name'],
      'email' => $validation['email'],
      'phone' => $validation['phone'],
      'city' => $validation['city'],
    ]);
    

    // Displaying the message
    $notification = array([
      'message' => 'WareHouse Is Inserted Successfully',
      'alert-type' => 'success'
    ]);

    return redirect()->route('all.warehouse')->with($notification);
  }

  // Edit WareHouse
  public function EditWareHouse($id){
    $warehouse = WareHouse::find($id);
    return view('admin.backend.warehouse.edit_warehouse', compact('warehouse'));
  }


  // Updating the WareHouse
  public function UpdateWareHouse(Request $request){
    $ware_id = $request->id;

    $validation = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'nullable|string|max:25',
      'city' => 'nullable|string|max:100',
    ]);


    // Updating the data
    WareHouse::find($ware_id)->update([
      'name' => $validation['name'],
      'email' => $validation['email'],
      'phone' => $validation['phone'],
      'city' => $validation['city']
    ]);

    // Displaying the notification
    $notification = array([
      'message' => 'The WareHouse has been updated successfully',
      'alert-type' => 'success'
    ]);

    return redirect()->route('all.warehouse')->with($notification);
  }

  // Deleting the warehouse
  public function DeleteWareHouse($id){
    WareHouse::find($id)->delete();

    $notification = array([
      'message' => 'The Warehouse has been deleted successfully',
      'alert-type' => 'success'
    ]);
    return redirect()->back()->with($notification);
  }
}