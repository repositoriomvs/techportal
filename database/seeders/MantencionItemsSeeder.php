<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MantencionItemsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mantencion_items')->delete();

        $items = [
            // ── IMPRESORA SIN ADF ──
            ['tipo_equipo'=>'impresora_sin_adf','seccion'=>'Limpieza','descripcion'=>'Limpieza exterior del equipo','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>1],
            ['tipo_equipo'=>'impresora_sin_adf','seccion'=>'Limpieza','descripcion'=>'Limpieza de bandeja de papel','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>2],
            ['tipo_equipo'=>'impresora_sin_adf','seccion'=>'Inspección','descripcion'=>'Bandeja de papel','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>3],
            ['tipo_equipo'=>'impresora_sin_adf','seccion'=>'Inspección','descripcion'=>'Rodillos de alimentación visibles','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>4],
            ['tipo_equipo'=>'impresora_sin_adf','seccion'=>'Inspección','descripcion'=>'Nivel de consumibles','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>5],
            ['tipo_equipo'=>'impresora_sin_adf','seccion'=>'Prueba Operativa','descripcion'=>'Encendido del equipo','tipo_respuesta'=>'A','es_critico'=>true,'orden'=>6],
            ['tipo_equipo'=>'impresora_sin_adf','seccion'=>'Prueba Operativa','descripcion'=>'Prueba de impresión','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>7],
            ['tipo_equipo'=>'impresora_sin_adf','seccion'=>'Prueba Operativa','descripcion'=>'Conexión USB o red','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>8],

            // ── IMPRESORA CON ADF ──
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Limpieza','descripcion'=>'Limpieza exterior del equipo','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>1],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Limpieza','descripcion'=>'Limpieza de bandejas de papel','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>2],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Limpieza','descripcion'=>'Limpieza de cristal del escáner','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>3],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Limpieza','descripcion'=>'Limpieza de rodillos ADF','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>4],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Inspección','descripcion'=>'Bandejas de papel','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>5],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Inspección','descripcion'=>'Alimentador automático ADF','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>6],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Inspección','descripcion'=>'Nivel de consumibles','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>7],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Prueba Operativa','descripcion'=>'Encendido del equipo','tipo_respuesta'=>'A','es_critico'=>true,'orden'=>8],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Prueba Operativa','descripcion'=>'Prueba de impresión','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>9],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Prueba Operativa','descripcion'=>'Prueba de escaneo','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>10],
            ['tipo_equipo'=>'impresora_con_adf','seccion'=>'Prueba Operativa','descripcion'=>'Conexión de red','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>11],

            // ── IMPRESORA TÉRMICA ──
            ['tipo_equipo'=>'impresora_termica','seccion'=>'Limpieza','descripcion'=>'Limpieza exterior del equipo','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>1],
            ['tipo_equipo'=>'impresora_termica','seccion'=>'Limpieza','descripcion'=>'Limpieza de cabezal térmico','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>2],
            ['tipo_equipo'=>'impresora_termica','seccion'=>'Limpieza','descripcion'=>'Limpieza de rodillo de arrastre','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>3],
            ['tipo_equipo'=>'impresora_termica','seccion'=>'Inspección','descripcion'=>'Sensor de papel','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>4],
            ['tipo_equipo'=>'impresora_termica','seccion'=>'Inspección','descripcion'=>'Mecanismo de corte','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>5],
            ['tipo_equipo'=>'impresora_termica','seccion'=>'Inspección','descripcion'=>'Cable de comunicación','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>6],
            ['tipo_equipo'=>'impresora_termica','seccion'=>'Prueba Operativa','descripcion'=>'Encendido del equipo','tipo_respuesta'=>'A','es_critico'=>true,'orden'=>7],
            ['tipo_equipo'=>'impresora_termica','seccion'=>'Prueba Operativa','descripcion'=>'Prueba de impresión','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>8],
            ['tipo_equipo'=>'impresora_termica','seccion'=>'Prueba Operativa','descripcion'=>'Comunicación con equipo conectado','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>9],

            // ── COMPUTADOR ALL IN ONE ──
            ['tipo_equipo'=>'computador_aio','seccion'=>'Limpieza','descripcion'=>'Limpieza de pantalla','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>1],
            ['tipo_equipo'=>'computador_aio','seccion'=>'Limpieza','descripcion'=>'Limpieza de ventilaciones','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>2],
            ['tipo_equipo'=>'computador_aio','seccion'=>'Limpieza','descripcion'=>'Limpieza exterior del equipo','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>3],
            ['tipo_equipo'=>'computador_aio','seccion'=>'Inspección','descripcion'=>'Cable de alimentación','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>4],
            ['tipo_equipo'=>'computador_aio','seccion'=>'Inspección','descripcion'=>'Conexión de red','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>5],
            ['tipo_equipo'=>'computador_aio','seccion'=>'Inspección','descripcion'=>'Teclado','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>6],
            ['tipo_equipo'=>'computador_aio','seccion'=>'Inspección','descripcion'=>'Mouse','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>7],
            ['tipo_equipo'=>'computador_aio','seccion'=>'Prueba Operativa','descripcion'=>'Encendido del equipo','tipo_respuesta'=>'A','es_critico'=>true,'orden'=>8],
            ['tipo_equipo'=>'computador_aio','seccion'=>'Prueba Operativa','descripcion'=>'Inicio del sistema operativo','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>9],
            ['tipo_equipo'=>'computador_aio','seccion'=>'Prueba Operativa','descripcion'=>'Conexión de red','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>10],

            // ── COMPUTADOR DESKTOP ──
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Limpieza','descripcion'=>'Limpieza exterior del gabinete','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>1],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Limpieza','descripcion'=>'Limpieza de ventilaciones','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>2],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Inspección','descripcion'=>'Cable de alimentación','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>3],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Inspección','descripcion'=>'Cable de red','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>4],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Inspección','descripcion'=>'Conexión de video','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>5],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Prueba Operativa','descripcion'=>'Encendido del equipo','tipo_respuesta'=>'A','es_critico'=>true,'orden'=>6],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Prueba Operativa','descripcion'=>'Inicio del sistema operativo','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>7],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Prueba Operativa','descripcion'=>'Conexión de red','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>8],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Periféricos','descripcion'=>'Monitor','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>9],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Periféricos','descripcion'=>'Teclado','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>10],
            ['tipo_equipo'=>'computador_desktop','seccion'=>'Periféricos','descripcion'=>'Mouse','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>11],

            // ── COMPUTADOR NOTEBOOK ──
            ['tipo_equipo'=>'computador_notebook','seccion'=>'Limpieza','descripcion'=>'Limpieza de pantalla','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>1],
            ['tipo_equipo'=>'computador_notebook','seccion'=>'Limpieza','descripcion'=>'Limpieza de teclado','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>2],
            ['tipo_equipo'=>'computador_notebook','seccion'=>'Limpieza','descripcion'=>'Limpieza de ventilaciones','tipo_respuesta'=>'B','es_critico'=>false,'orden'=>3],
            ['tipo_equipo'=>'computador_notebook','seccion'=>'Inspección','descripcion'=>'Cargador','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>4],
            ['tipo_equipo'=>'computador_notebook','seccion'=>'Inspección','descripcion'=>'Puertos del equipo','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>5],
            ['tipo_equipo'=>'computador_notebook','seccion'=>'Inspección','descripcion'=>'Batería','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>6],
            ['tipo_equipo'=>'computador_notebook','seccion'=>'Prueba Operativa','descripcion'=>'Encendido del equipo','tipo_respuesta'=>'A','es_critico'=>true,'orden'=>7],
            ['tipo_equipo'=>'computador_notebook','seccion'=>'Prueba Operativa','descripcion'=>'Inicio del sistema operativo','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>8],
            ['tipo_equipo'=>'computador_notebook','seccion'=>'Prueba Operativa','descripcion'=>'Conexión de red','tipo_respuesta'=>'A','es_critico'=>false,'orden'=>9],
        ];

        $now = now();
        foreach ($items as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        DB::table('mantencion_items')->insert($items);
    }
}