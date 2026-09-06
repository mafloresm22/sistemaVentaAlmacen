<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompras extends Model
{
    protected $table = 'detalle_compras';
    protected $primaryKey = 'idDetalleCompras';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'cantidadDetalleCompras',
        'precioUnitarioDetalleCompras',
        'subtotalDetalleCompras',
        'comprasid',
        'productosid',
    ];

    // Relación con Compras
    public function compra()
    {
        return $this->belongsTo(Compras::class, 'comprasid', 'idCompras');
    }

    // Relación con Productos
    public function producto()
    {
        return $this->belongsTo(Productos::class, 'productosid', 'idProductos');
    }
}
