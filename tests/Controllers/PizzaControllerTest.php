<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PizzaControllerTest extends TestCase
{
    public function testPizzaIndex()
    {
        $this->visitRoute('pizzas.index');
    }
}
