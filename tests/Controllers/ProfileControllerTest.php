<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testProfileIndex()
    {
        $user = factory(App\User::class)->create();
        
        $this->actingAs($user)
            ->visitRoute('profile.index');
    }

    public function testProfileUpdate()
    {
        $user = factory(App\User::class)->create();
        
        $phoneNumber = '06123456789101';
        $this->actingAs($user)
            ->visitRoute('profile.index')
            ->submitForm('Update', ['phone_number' => $phoneNumber]);

        $this->seeInDatabase('users', [
            'id'            => $user->id,
            'phone_number'  => $phoneNumber,
        ]);

        $this->seePageIs(route('profile.index'));
    }
}
