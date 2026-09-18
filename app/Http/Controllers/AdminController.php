<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Http\Request;
use App\Models\User;


class AdminController extends Controller
{
	// Logout method start
	public function AdminLogout(Request $request){
		Auth::guard('web')->logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/login');
	}
	// Logout method end


	// Profile method start
	public function AdminProfile(){
		$id = Auth::user()->id;
		$profileData = User::find($id);
		return view('admin.admin_profile', compact('profileData'));
	}
	// Profile method end


	// Profile update start
	public function ProfileStore(Request $request){
		$id = Auth::user()->id;
		$data = User::find($id);

		// inputs fields in the database table
		$data->name = $request->name;
		$data->email = $request->email;
		$data->phone = $request->phone;
		$data->address = $request->address;

		// Updating the image file
		$oldPhotoPath = $data->photo;
		if($request->hasFile('photo')){
			$file = $request->file('photo');
			$fileName = time().'.'.$file->getClientOriginalExtension();
			$file->move(public_path('upload/user_images/'), $fileName);
			$data->photo = $fileName;
			
			if ($oldPhotoPath && $oldPhotoPath !== $fileName) {
				$this->deleteOldImage($oldPhotoPath);
			}
		}

		$data->save();

		// Notifaction
		$notification = array(
			'message' => 'Admin Profile Updated Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
	}
	// Profile update end


	// Deleting the old image.
	private function deleteOldImage(string $oldPhotoPath) : void {
		$fullPath = public_path('upload/user_images/'.$oldPhotoPath);
		if (file_exists($fullPath)) {
			unlink($fullPath);
		}
	}


	public function AdminPasswordUpdate(Request $request){
		$user = Auth::user();
		$request->validate([
			'old_password' => 'required',
			'new_password' => 'required|confirmed'
		]);

		// checking the old password & comparing it with password in the db
		if (!Hash::check($request->old_password, $user->password)) {
			$notification = array(
				'message' => 'Old Password Does Not Match',
				'alert-type' => 'error'
			);
			return back()->with($notification);
		}

		User::whereId($user->id)->update([
			'password' => Hash::make($request->new_password)
		]);

		Auth::logout();
		
		$notification = array(
				'message' => 'Password Updated Successfully',
				'alert-type' => 'success'
			);
		return redirect()->route('login')->with($notification);
	}
}