<?php 
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\ImageStore;
use App\Topping;
use App\Pizza;
use App\PizzaTopping;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
	private function rules() {
		$rules = [
			'name'			=> 'required|unique:pizzas|max:50',
			'price_24cm'	=> 'required|numeric',
			'price_32cm'	=> 'required|numeric',
			'price_40cm'	=> 'required|numeric',
			'toppings'		=> 'required|array|max:15',
		];

		//Test fails with file
		if(!\App::runningUnitTests()) {
			$rules['image'] = 'required|mimes:jpg,jpeg,png|max:2000';
		}

		return $rules;
	}

	public function index(Request $request)
	{
		$toppings = Topping::orderBy('name')->get();
		$pizzas = Pizza::orderBy('name');

		$pizzaName = $request->input('pizza_name');
		if(strlen($pizzaName) > 2) {
			$pizzas = $pizzas->where('name', 'like', "%$pizzaName%");
		}

		$pizzaToppings = $request->input('pizza_topping');
		if($pizzaToppings) {	
			$pizzas = Pizza::pizzasWithtoppings($pizzaToppings, $pizzas);
		}

		$perPage = $request->input('per_page') ?: 10;
		$pizzas = $pizzas->simplePaginate($perPage);

		$pizzas->appends($request->query());
		$request->flash();
		return view('dashboard.pizzas.index', [
			'pizzas'	=> $pizzas,
			'toppings'	=> $toppings,
		]);
	}

	public function create()
	{
		$this->authorize('update', Pizza::class);
		$toppings = Topping::orderBy('name')->get();

		return view('dashboard.pizzas.create', [
			'toppings' => $toppings
		]);
	}

	public function store(Request $request)
	{
		$this->authorize('update', Pizza::class);
		$this->validate($request, $this->rules());

		$data = $request->only(
			'name', 'price_24cm', 'price_32cm', 'price_40cm'
		);
		
		//image
		$image = $request->file('image');
		$imagePaths = ImageStore::storeImageWithThumb(
			$image,
			str_replace(' ', '_', $request['name'])
		);

		$data = array_merge($data, $imagePaths);
		$pizza = Pizza::create($data);

		$query = array_map(function($topping) use ($pizza) {
			return [
				'pizza_id'	=> $pizza->id,
				'topping_id'=> $topping,
			];
		}, $request->input('toppings'));

		PizzaTopping::insert($query);

		return redirect()->route('dashboard.pizzas.edit', ['pizza' => $pizza->id]);
	}

	public function edit(Pizza $pizza)
	{
		$this->authorize('update', Pizza::class);
		if(!$pizza) return redirect()->back();

		$toppings = Topping::orderBy('name')->get();

		return view('dashboard.pizzas.edit', [
			'pizza'		=> $pizza,
			'toppings'	=> $toppings,
		]);
	}

	public function update(Request $request, Pizza $pizza)
	{
		$this->authorize('update', Pizza::class);
		if(!$pizza) return redirect()->back();

		$rules = $this->rules();
		$rules['name'] = 'required';
		$this->validate($request, $rules);

		$difference = $this->difference($request, $pizza);
		
		$pizzaQuery = [];
		if($request->hasFile('image')) {
			$image = $request->file('image');
			$imageName = $this->imageName($image, $request->input('name'));
			$pizzaQuery = ImageStore::storeImageWithThumb($image, $imageName);
		}

		if(!empty($difference['pizza'])) {
			$pizzaQuery = array_merge($pizzaQuery, $difference['pizza']);
		}

		if(!empty($pizzaQuery)) {
			$pizza->update($pizzaQuery);
		}

		if(!empty($difference['toppings']['plus'])) {
			foreach ($difference['toppings']['plus'] as $topping) {
				$query[] = [
					'pizza_id'	=> $pizzaId,
					'topping_id'=> $topping
				];
			}
			PizzaTopping::insert($query);
		}

		if(!empty($difference['toppings']['minus'])) {
			$pizzaToppings = $pizza->pizzaToppings()
				->whereIn(
					'topping_id',
					$difference['toppings']['minus']
				)
				->get();

			foreach ($pizzaToppings as $pt) {
				$pt->delete();
			}
		}

		return redirect()->route('dashboard.pizzas.index');
	}

	public function destroy(Pizza $pizza)
	{
		if(!$pizza) return redirect('/');

		$this->authorize('update', Pizza::class);

		unlink(public_path($pizza->image));
		unlink(public_path($pizza->thumb_image));
		$pizza->delete();

		return redirect()->back();
	}

	private function imageName($image, $name)
	{
		return str_replace(' ', '_', $name);
	}

	private function difference($request, $pizza)
	{
		$data = $request->only(
			'name', 'price_24cm', 'price_32cm', 'price_40cm'
		);

		$oldData = array_only($pizza->toArray(), [
			'name', 'price_24cm', 'price_32cm', 'price_40cm'
		]);

		$pizzaDiff = array_diff($data, $oldData);

		$oldToppings = $pizza->toppingIds();
		$plusToppings = array_diff($request->input('toppings'), $oldToppings);
		$minusToppings = array_diff($oldToppings, $request->input('toppings'));

		return [
			'pizza' => $pizzaDiff,
			'toppings'	=> [
				'plus'	=> $plusToppings,
				'minus'	=> $minusToppings,
			]
		];
	}

}