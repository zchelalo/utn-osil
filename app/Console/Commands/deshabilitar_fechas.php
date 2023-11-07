<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\fechas;

class deshabilitar_fechas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deshabilitar_fechas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deshabilita fechas si la fecha actual supera la fecha de finalización.';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $fechas = fechas::where('activo', 1)->get();

        foreach ($fechas as $fecha) {
            $fecha->deshabilitarFecha();
        }
    }
}
