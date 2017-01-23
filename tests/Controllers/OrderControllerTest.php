<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderControllerTest extends TestCase
{
    use DatabaseTransactions;
    //use WithoutMiddleware;
    
    public function testOrderShow()
    {
        $user = factory(App\User::class)->create();
        $address = $user->addresses()->save(
            factory(App\Address::class)->make()
        );
        $order = $user->orders()->save(
            factory(App\Order::class)->make([
                'address_id'    => $address->id,
                'address'       => $address->formated()
            ])
        );
        $order->items()->save(
            factory(App\OrderItem::class)->make()
        );

        $this->actingAs($user)
            ->visitRoute('orders.show', ['order' => $order->id]);
    }

    public function testOrderStore()
    {
        $user = factory(App\User::class)->create();
        $address = $user->addresses()->save(
            factory(App\Address::class)->make()
        );

        $order = [
			'items'         => $this->orderItems(),
			'comment'       => str_random(10),
			'address_id'    => $address->id,
        ];

		$this->actingAs($user)
			->json('POST', '/orders', ['order' => $order])
			->seeJsonStructure([
				'redirect'
			]);
    }

    private function orderItems()
    {
        $pizzas = factory(App\Pizza::class, 3)->create();
        $items = array_map(function($pizza) {
            $pieces = rand(1,3);

            return [
                'id'        => $pizza['id'],
                'name'      => $pizza['name'],
                'pieces'    => $pieces,
                'size'      => 32,
                'price'     => $pizza['price_32cm'] * $pieces
            ];
        }, $pizzas->toArray());

        return $items;
    }
}
