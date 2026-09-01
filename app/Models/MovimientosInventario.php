<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosInventario extends Model
{
    protected $table = 'movimientos_inventarios';
    protected $primaryKey = 'idMovimientosInventario';

    protected $fillable = [
        'tipoMovimientoInventario',
        'cantidadMovimientoInventario',
        'fechaMovimientoInventario',
        'observacionesMovimientoInventario',
        'productoid',
        'sucursalid',
        'usersid',
        'proveedoresid'
    ];
}
