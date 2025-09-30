<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceStatus;

class ServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['code' => 'RECEIVED',   'label' => 'Recibido',   'is_final' => false, 'sort_order' => 10],
            ['code' => 'DIAGNOSING', 'label' => 'Diagnosticando', 'is_final' => false, 'sort_order' => 20],
            ['code' => 'REPAIRING',  'label' => 'Reparando',  'is_final' => false, 'sort_order' => 30],
            ['code' => 'FINISHED',   'label' => 'Finalizado', 'is_final' => false, 'sort_order' => 40],
            ['code' => 'DELIVERED',  'label' => 'Entregado',  'is_final' => true,  'sort_order' => 50],
            ['code' => 'CANCELED',   'label' => 'Cancelado',  'is_final' => true,  'sort_order' => 60],
        ];
        foreach ($rows as $r) {
            ServiceStatus::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
