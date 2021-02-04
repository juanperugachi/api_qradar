<?php

namespace App\Models;

use App\Models\Frecuencia;
use App\Models\Pais;
use App\Models\Cliente;
use App\Models\Area;
use App\Models\Mantenimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contrato extends Model
{
    protected $table = 'contratos';
    protected $fillable = ['descripcion',
                            'fecha_inicio',
                            'fecha_fin',
                            'dia_elegido',
                            'cliente_id',
                            'pais_id',
                            'area_id',
                            'solucion',
                            'marca',
                            'frecuencia',
                            'mantenimientos',
                            'correos',
                            'observacion',
                            'fecha_creacion','estado'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function cliente(){
    	return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
    public function pais(){
    	return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }
    public function area(){
    	return $this->belongsTo(Area::class, 'area_id', 'id');
    }
    public function mantenimiento()
    {
        return $this->hasMany(Mantenimiento::class, 'contrato_id', 'id');
    }
    public function frecuencias()
    {
        return $this->belongsTo(Frecuencia::class, 'frecuencia', 'id');
    }
}
