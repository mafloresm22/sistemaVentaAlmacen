<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'idVentas';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'metodoVentas',
        'codigoVentas',
        'totalVentas',
        'fechaCompraVentas',
        'clientesid',
        'estadoVentas',
    ];

    // Relación con Clientes
    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'clientesid', 'idClientes');
    }

    // Relación con DetalleVentas
    public function detalles()
    {
        return $this->hasMany(DetalleVentas::class, 'ventasid', 'idVentas');
    }
}
