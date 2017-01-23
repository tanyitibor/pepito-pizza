<?php 
namespace App\Http\Controllers\Dashboard;

use App\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	public function index(Request $request)
	{
		$this->authorize('list', 'App\Order');
		$orders = Order::orderBy('created_at', 'desc');

		$statuses = $request->input('status') ?: [];
		if($statuses) {
			$orders->whereIn('status_id', $statuses);
		}

		$perPage = $request->input('per_page') ?: 10;
		$orders = $orders->simplePaginate($perPage);

		$orders->appends($request->query());
		$request->flash();
		return view('dashboard.orders.index', [
			'orders'	=> $orders,
			'statuses'	=> $statuses
		]);
	}

	public function update(Request $request, Order $order)
	{
		if(!$order) redirect()->back();
		
		$this->authorize('update', $order);

		$statuses = Order::$statuses;
		$this->validate($request, [
			'status'	=> 'integer|between:0,' . (count($statuses)-1)
		]);

		$order->update([
			'status_id'	=> $request->input('status')
		]);

		return redirect()->back();
	}
}