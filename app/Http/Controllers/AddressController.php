<?php 
namespace App\Http\Controllers;

use App\Address;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
	private $rules = [
		'name'			=> 'required|string|max:255',
		'zip_code'		=> 'required|digits:4',
		'state'			=> 'required|string|max:255',
		'city'			=> 'required|string|max:255',
		'address_line'	=> 'required|string|max:255',
	];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function store(Request $request)
	{
		$this->validate($request, $this->rules);

		$infos = $request->only('name', 'zip_code', 'state', 'city', 'address_line');
		$infos['user_id'] = Auth::user()->id;
		Address::create($infos);
		
		return redirect()->back();
	}

	public function update(Request $request, Address $address)
	{
		if(!$address || $address->user_id != Auth::user()->id) {
			return redirect()->back();
		}

		$this->validate($request, $this->rules);

		$old = array_except(
            $address->toArray(),
            ['id', 'user_id']
        );

		$diff = array_diff(
			$request->only('name', 'zip_code', 'state', 'city', 'address_line'),
			$old
		);

		$address->update($diff);

		return redirect()->back();
	}

	public function destroy(Address $address)
	{
		if($address && $address->user_id == Auth::user()->id) $address->delete();

		return redirect()->back();
	}
}