<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = ['pizzas', 'toppings', 'pizza_toppings'];
        $sourceDir = 'database/seeds/sources/';

        foreach($tables as $table) {
            //Delete rows from tables and reset auto_increment
            DB::table($table)->truncate();
            DB::update('ALTER TABLE ' . $table . ' AUTO_INCREMENT = 1;');

            $seed = json_decode(file_get_contents($sourceDir . $table . '.json'), 1);
            if(DB::table($table)->insert($seed) && $table == 'pizzas') {
                $this->createPizzaImages($seed);
            };
        }
    }

    private function createPizzaImages($pizzas) {
        foreach($pizzas as $pizza) {
            $name = str_replace(' ', '_', $pizza['name']);
            $image = new UploadedFile('database/seeds/sources/pizza.png', $name, null, null, null, true);
            \App\ImageStore::storeImageWithThumb($image, $name);
        }
    }
}
