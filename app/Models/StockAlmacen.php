<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAlmacen extends Model
{
    protected $table = 'stock_almacenes';
    protected $primaryKey = 'idStockAlmacen';

    protected $fillable = [
        'stockactualAlmacen',
        'stockminimoAlmacen',
        'estadoStockAlmacen',
        'productoid',
        'sucursalid'
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'productoid', 'idProductos');
    }
}
