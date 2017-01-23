<?php 
namespace App\Http\Controllers;

use App\Address;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$orders = Auth::user()
			->orders()
			->simplePaginate(5);

		return view('profile.index', ['orders' => $orders]);
	}

	public function update(Request $request)
	{
		$this->validate($request, [
			'phone_number'	=> 'required|min:11|max:16',
		]);

		Auth::user()->update(
			$request->only('phone_number')
		);

		return redirect()->back();
	}

}