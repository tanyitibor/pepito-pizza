<?php
namespace Dashboard;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ToppingControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = factory(\App\User::class)->create();
        $user->permission()->save(
            new \App\Permission(['modify_toppings' => 1])
        );

        $this->actingAs($user);
    }

    public function testToppingIndex()
    {
        $this->visitRoute('dashboard.toppings.index');
    }

    public function testToppingStore()
    {
        $topping = factory(\App\Topping::class)->make();

        $this->visitRoute('dashboard.toppings.index')
            ->submitForm('Add', $topping->toArray());

        $this->seeInDatabase('toppings', $topping->toArray());
    }

    public function testToppingUpdate()
    {
        $topping = factory(\App\Topping::class)->make();

        $this->visitRoute('dashboard.toppings.index')
            ->submitForm('Submit', $topping->toArray());
    }

    public function testToppingDestroy()
    {
        $topping = factory(\App\Topping::class)->create();

        $this->visit(route('dashboard.toppings.index') . '?per_page=100')
            ->submitForm('delete-topping-' . $topping->id);

        $this->dontSeeInDatabase('toppings', $topping->toArray());

        $this->dontSeeInDatabase('pizza_toppings', [
            'topping_id' => $topping->id,
        ]);
    }
}
