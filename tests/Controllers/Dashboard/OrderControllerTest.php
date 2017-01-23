<?php
namespace Dashboard;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function testOrderIndex()
    {
        $user = factory(\App\User::class)->create();
        $user->permission()->save(
            new \App\Permission(['see_orders' => 1])
        );

        $this->actingAs($user)
            ->visitRoute('dashboard.users.index');
    }
}
