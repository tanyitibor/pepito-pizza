<?php 
namespace App\Http\Controllers\Dashboard;

use App\Topping;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToppingController extends Controller
{

	public function __construct()
	{
		$this->middleware('can:update,App\Topping');
	}

	private function rules()
	{
		return [
			'name'	=> 'required|regex:/^[\pL\s\-]+$/u|max:30|unique:toppings',
		];
	}

	public function index(Request $request)
	{		
		$perPage = $request->input('per_page') ?: 10;
		$toppings = Topping::simplePaginate($perPage);

		return view('dashboard.toppings.index', ['toppings' => $toppings]);
	}

	public function store(Request $request)
	{
		$this->validate($request, $this->rules());

		Topping::insert($request->only('name'));

		return redirect()->back();
	}

	public function update(Request $request, Topping $topping)
	{
		if(!$topping) return redirect()->back();

		$this->validate($request, $this->rules());

		$topping->name = $request->input('name');
		$topping->save();

		return redirect()->back();
	}

	public function destroy(Topping $topping)
	{
		if($topping) {
			$topping->pizzaToppings()
				->delete();
			$topping->delete();
		}

		return redirect()->back();
	}
}