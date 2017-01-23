<?php
namespace App\Http\Controllers;

use App\Address;
use App\Order;
use App\OrderItem;
use App\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class OrderController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function store(Request $request)
	{
		$order = $request->get('order');
		$userId = Auth::user()->id;

		//correct_address rule has been added in App\Providers\AppServiceProvider
		$validator = Validator::make($order, [
			'comment'			=> "string|max:255",
			'address_id'		=> "required|correct_address:{$userId}",
			'items.*.id'		=> 'required|exists:pizzas',
			'items.*.size'		=> 'required|in:24,32,40',
			'items.*.pieces'	=> 'required|integer|min:1|max:30'
		]);

		if($validator->fails()){
			return response()->json(['error' => $validator->failed()]);
		}

		$address = Address::find($order['address_id']);

		$newOrder = Order::create([
			'user_id'	=> $userId,
			'comment'	=> $order['comment'],
			'status_id'	=> Order::statusByName('pending'),
			'address_id'=> $order['address_id'],
			'address'	=> $address->formated(),
		]);

		$orderItems = array_map(function($item) use ($newOrder) {
			$pizza = Pizza::find($item['id']);
			$price = $pizza->price($item['size']);

			return [
				'order_id'	=> $newOrder->id,
				'pizza_id'	=> $item['id'],
				'pieces'	=> $item['pieces'],
				'size'		=> $item['size'],
				'price'		=> $price * $item['pieces']
			];
		}, $order['items']);

		OrderItem::insert($orderItems);

		return response()->json([
			'redirect'=> route('orders.show', ['order' => $newOrder->id])
		]);
	}

	public function show(Request $request, Order $order)
	{
		if(!$order) return redirect()->back();

		$this->authorize('see', $order);

		return view('order.show', ['order' => $order]);
	}
}