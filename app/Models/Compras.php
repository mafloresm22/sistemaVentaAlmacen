<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'idCompras';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'numeroFacturaCompras',
        'fechaEmisionCompras',
        'totalCompras',
        'estadoCompras',
        'proveedoresid',
        'sucursalesid',
        'usersid',
    ];

    // Relación con Proveedores
    public function proveedor()
    {
        return $this->belongsTo(Proveedores::class, 'proveedoresid', 'idProveedores');
    }

    // Relación con Sucursales
    public function sucursal()
    {
        return $this->belongsTo(Sucursales::class, 'sucursalesid', 'idSucursales');
    }

    // Relación con Users
    public function user()
    {
        return $this->belongsTo(User::class, 'usersid', 'id');
    }

    // Relación con DetalleCompras
    public function detalles()
    {
        return $this->hasMany(DetalleCompras::class, 'comprasid', 'idCompras');
    }
}
