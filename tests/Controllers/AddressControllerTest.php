<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddressControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddressStore()
    {
        $user = factory(App\User::class)->create();
        $address = $user->addresses()->save(
            factory(App\Address::class)->make()
        );

        $old = array_except(
            $address->toArray(),
            ['id', 'user_id']
        );

        $this->actingAs($user)
            ->visitRoute('profile.index')
            ->submitForm('submit-address', $old);

        $this->seeInDatabase('addresses', $old);

        $this->seePageIs(route('profile.index'));
    }

    public function testAddressDestroy()
    {
        $user = factory(App\User::class)->create();
        $address = $user->addresses()->save(
            factory(App\Address::class)->make()
        );

        $this->actingAs($user)
            ->visitRoute('profile.index')
            ->submitForm('delete-' . $address->id);

        $this->dontSeeInDatabase('addresses', [
            'id'    => $address->id
        ]);
    }
}
