<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Tareas;
use App\Mail\TareasEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert sendend to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
             $alerta_fechas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
                            ->whereRaw('fecha_alerta = curdate()')->get();
                foreach ($alerta_fechas as $item) {
                    $details = [

                        'title' => 'Notificacion de alerta',
                        'body' => 'Se ha disparado la siguiente alerta',
                        'cliente' => $item->contrato->cliente->razon_social,
                        'fecha_entrega' => $item->fecha,
                        'tipo_tarea' => $item->tipo->nombre

                    ];
                    Mail::to($item->usuario->email)->send(new TareasEmail($details));
                    $item->alerta_enviada = 1;
                    $item->save();
                }

        $this->info('Successfully sent daily quote to everyone.');
    }
}
