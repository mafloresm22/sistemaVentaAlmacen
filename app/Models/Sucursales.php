<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    protected $table = 'sucursales';
    protected $primaryKey = 'idSucursales';

    protected $fillable = [
        'nombreSucursales',
        'ubicacionSucursales',
    ];


    public function MovimientosInventarios()
    {
        return $this->hasMany(MovimientosInventario::class, 'sucursalid', 'idSucursales');
    }

    public function Compras()
    {
        return $this->hasMany(Compras::class, 'sucursalesid', 'idSucursales');
    }

    public function StockAlmacen()
    {
        return $this->hasMany(StockAlmacen::class, 'sucursalid', 'idSucursales');
    }
}
