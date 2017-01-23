<?php
namespace Dashboard;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;

class PizzaControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = factory(\App\User::class)->create();
        $user->permission()->save(
            new \App\Permission(['modify_pizzas' => 1])
        );

        $this->actingAs($user);
    }

    public function testPizzaIndex()
    {
        $this->visitRoute('dashboard.pizzas.index');
    }

    public function testPizzaCreate()
    {
        $this->visitRoute('dashboard.pizzas.create');
    }

    public function testPizzaStore()
    {
    	$pizza = factory(\App\Pizza::class)->make();
        $toppings = $this->randomToppings();

        $image = new \Illuminate\Http\UploadedFile(
            base_path('tests/Controllers/Dashboard/pizza.png'),
            null, null, null, null, true
        );

        $input = [
    		'name'			=> $pizza->name,
    		'price_24cm'	=> $pizza->price_24cm,
    		'price_32cm'	=> $pizza->price_32cm,
    		'price_40cm'	=> $pizza->price_40cm,
    		'toppings'  	=> $toppings,
            'image'         => $image,
    	];

		$this->visitRoute('dashboard.pizzas.create')
			->submitForm('submit', $input);

        /*
        $this->seeInDatabase('pizzas', [
            'name'          => $pizza->name,
            'price_24cm'    => $pizza->price_24cm,
            'price_32cm'    => $pizza->price_32cm,
            'price_40cm'    => $pizza->price_40cm,
        ]);*/


        $pizzaInDB = \DB::table('pizzas')
            ->where('name', $pizza->name)
            ->first();

        foreach ($toppings as $topping) {
            $this->seeInDatabase('pizza_toppings', [
                'pizza_id'      => $pizzaInDB->id,
                'topping_id'    => $topping
            ]);
        }
        
        $this->seePageIs(route('dashboard.pizzas.edit', ['pizza' => $pizzaInDB->id]));

        $imagePath = 'public/' . $pizzaInDB->image;
        $thumbPath = 'public/' . $pizzaInDB->thumb_image;
        $this->assertFileExists($imagePath);
        $this->assertFileExists($thumbPath);

        //delete images
        unlink(base_path($imagePath));
        unlink(base_path($thumbPath));
    }

    
    public function testPizzaEdit()
    {
        $pizza = factory(\App\Pizza::class)->create();

        $this->visitRoute('dashboard.pizzas.edit', ['pizza' => $pizza->id]);
    }

    private function randomToppings()
    {
    	$toppings = \App\Topping::orderBy('name')
            ->pluck('id')
            ->toArray();

    	//select random
    	$keys = array_rand($toppings, rand(2,4));
        $randIngr = [];
        foreach ($keys as $key) {
            $randIngr[$key] = $toppings[$key];
        }
    	
    	return $randIngr;
    }
}
