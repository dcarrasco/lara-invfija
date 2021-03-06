<?php

use Illuminate\Database\Seeder;

class TablaACLModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---------------------------------------------------------------------
        // ACL
        // ---------------------------------------------------------------------
        // 1
        DB::table('acl_modulo')->insert([
            'app_id' => 1,
            'modulo' => 'Config ACL',
            'descripcion' => 'Config ACL',
            'llave_modulo' => '4bd0769215f77e7',
            'icono' => '',
            'url' => 'aclConfig.index',
            'orden' => 10,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // ---------------------------------------------------------------------
        // Inventario
        // ---------------------------------------------------------------------
        // 2
        DB::table('acl_modulo')->insert([
            'app_id' => 2,
            'modulo' => 'Config Inventario',
            'descripcion' => 'Config Inventario',
            'llave_modulo' => '81b87511e28532f',
            'icono' => '',
            'url' => 'inventarioConfig.index',
            'orden' => 10,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 3
        DB::table('acl_modulo')->insert([
            'app_id' => 2,
            'modulo' => 'Digitar Inventario',
            'descripcion' => 'Digitar Inventario',
            'llave_modulo' => 'b386b510e56f73e',
            'icono' => '',
            'url' => 'inventario.showHoja',
            'orden' => 20,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 4
        DB::table('acl_modulo')->insert([
            'app_id' => 2,
            'modulo' => 'Reportes',
            'descripcion' => 'Reportes',
            'llave_modulo' => '2dfc992232fe108',
            'icono' => '',
            'url' => 'inventario.reporte',
            'orden' => 30,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 5
        DB::table('acl_modulo')->insert([
            'app_id' => 2,
            'modulo' => 'Ajustes',
            'descripcion' => 'Ajustes',
            'llave_modulo' => 'fda0416c87cceb5',
            'icono' => '',
            'url' => 'inventario.ajustes',
            'orden' => 40,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // ---------------------------------------------------------------------
        // Stock
        // ---------------------------------------------------------------------
        // 6
        DB::table('acl_modulo')->insert([
            'app_id' => 3,
            'modulo' => 'Config Stock',
            'descripcion' => 'Config Stock',
            'llave_modulo' => '46f163ae6eddc0c',
            'icono' => '',
            'url' => 'stockConfig.index',
            'orden' => 10,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 7
        DB::table('acl_modulo')->insert([
            'app_id' => 3,
            'modulo' => 'Analisis series',
            'descripcion' => 'Analisis series',
            'llave_modulo' => '02173df489952b0',
            'icono' => '',
            'url' => 'stock.analisisSeries',
            'orden' => 20,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 8
        DB::table('acl_modulo')->insert([
            'app_id' => 3,
            'modulo' => 'Consulta Stock',
            'descripcion' => 'Consulta Stock',
            'llave_modulo' => 'a37f5a1e01ed158',
            'icono' => '',
            'url' => 'stock.consultaStockMovil',
            'orden' => 30,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // ---------------------------------------------------------------------
        // TOA
        // ---------------------------------------------------------------------
        // 9
        DB::table('acl_modulo')->insert([
            'app_id' => 4,
            'modulo' => 'Config TOA',
            'descripcion' => 'Config TOA',
            'llave_modulo' => '80aa1468e0a10ca',
            'icono' => '',
            'url' => 'toaConfig.index',
            'orden' => 10,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 10
        DB::table('acl_modulo')->insert([
            'app_id' => 4,
            'modulo' => 'Peticion',
            'descripcion' => 'Peticion',
            'llave_modulo' => '470d090393a1e7f',
            'icono' => '',
            'url' => 'toa.peticion',
            'orden' => 20,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 11
        DB::table('acl_modulo')->insert([
            'app_id' => 4,
            'modulo' => 'Controles',
            'descripcion' => 'Controles',
            'llave_modulo' => 'cd3b54ac404725c',
            'icono' => '',
            'url' => 'toa.controles',
            'orden' => 30,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 12
        DB::table('acl_modulo')->insert([
            'app_id' => 4,
            'modulo' => 'Consumos',
            'descripcion' => 'Consumos',
            'llave_modulo' => '0bbf9db94624559',
            'icono' => '',
            'url' => 'toa.consumos',
            'orden' => 40,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 13
        DB::table('acl_modulo')->insert([
            'app_id' => 4,
            'modulo' => 'Asignacion',
            'descripcion' => 'Asignacion',
            'llave_modulo' => 'd5db321c52cc9aa',
            'icono' => '',
            'url' => 'toa.asignacion',
            'orden' => 50,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // ---------------------------------------------------------------------
        // Gastos
        // ---------------------------------------------------------------------
        // 14
        DB::table('acl_modulo')->insert([
            'app_id' => 5,
            'modulo' => 'Config Gastos',
            'descripcion' => 'Configuración gastos',
            'llave_modulo' => 'sv8346jhsguan2o',
            'icono' => 'cogs',
            'url' => 'gastosConfig.index',
            'orden' => 90,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 15
        DB::table('acl_modulo')->insert([
            'app_id' => 5,
            'modulo' => 'Ingreso Gastos',
            'descripcion' => 'Ingreso gastos',
            'llave_modulo' => 'insh85tons930ic',
            'icono' => 'calculator',
            'url' => 'gastos.showMes',
            'orden' => 10,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 16
        DB::table('acl_modulo')->insert([
            'app_id' => 5,
            'modulo' => 'Reporte gastos',
            'descripcion' => 'Reporte gastos',
            'llave_modulo' => 'pd7nd92jtopol0q',
            'icono' => 'table',
            'url' => 'gastos.reporte',
            'orden' => 20,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 17
        DB::table('acl_modulo')->insert([
            'app_id' => 5,
            'modulo' => 'Ingreso masivo',
            'descripcion' => 'Ingreso masivo',
            'llave_modulo' => 'oms73ueg39dmn03',
            'icono' => 'calculator',
            'url' => 'gastos.ingresoMasivo',
            'orden' => 40,
            'created_at' => Carbon\Carbon::now(),
        ]);

        // 18
        DB::table('acl_modulo')->insert([
            'app_id' => 5,
            'modulo' => 'Ingreso inversiones',
            'descripcion' => 'Ingreso inversiones',
            'llave_modulo' => '837dhpo93hnbq3v',
            'icono' => 'calculator',
            'url' => 'gastos.ingresoInversion',
            'orden' => 30,
            'created_at' => Carbon\Carbon::now(),
        ]);

    }
}
