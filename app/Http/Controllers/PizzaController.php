<?php
namespace App\Http\Controllers;

use App\Pizza;
use App\Topping;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
	public function index(Request $request)
	{
		$toppings = Topping::orderBy('name')->get();
		$pizzas = Pizza::orderBy('name');

		$pizzaName = $request->input('pizza_name');
		if($pizzaName) {
			$pizzas = $pizzas->where('name', 'like', "%$pizzaName%");
		}

		$pizzaToppings = $request->input('pizza_topping');
		if($pizzaToppings) {	
			$pizzas = Pizza::pizzasWithToppings($pizzaToppings, $pizzas);
		}

		$perPage = $request->input('per_page') ?: 10;
		$pizzas = $pizzas->simplePaginate($perPage);

		$pizzas->appends($request->query());
		$request->flash();
		return view('pizzas.index', [
			'pizzas'	=> $pizzas,
			'toppings'	=> $toppings,
		]);
	}
}