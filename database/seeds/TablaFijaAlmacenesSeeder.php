<?php

use Illuminate\Database\Seeder;

class TablaFijaAlmacenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Inventario\Almacen::class, 10)->create();
    }
}
