<?php
namespace Dashboard;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function testUserIndex()
    {
        $user = factory(\App\User::class)->create();
        $user->permission()->save(
            new \App\Permission(['see_orders' => 1])
        );

        $this->actingAs($user)
            ->visitRoute('dashboard.users.index');
    }

    public function testUserUpdate()
    {
        $user1 = factory(\App\User::class)->create();
        $user1->permission()->save(
            new \App\Permission([
                'modify_employees' => 1,
            ])
        );

        $user2 = factory(\App\User::class)->create();

        $input = array_filter(\App\Permission::PERMISSIONS,
            function() {
                return rand(0,1) == 1;
            }
        );

        $this->actingAs($user1)
            ->visit(route('dashboard.users.index') . '?per_page=100')
            ->submitForm("update-user-$user2->id", [
                'permissions' => $input
            ]);

        $shouldSeeInDb = array_reduce(\App\Permission::PERMISSIONS,
			function($result, $item) use($input) {
				$result[$item] = in_array($item, $input) ? 1 : 0;
				return $result;
			}
		);

        $shouldSeeInDb['user_id'] = $user2->id;
        
        $this->seeInDatabase('permissions', $shouldSeeInDb);
    }
}
