<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Observers\ProductosObserver;

#[ObservedBy(ProductosObserver::class)]
class Productos extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'idProductos';

    protected $fillable = [
        'codigoProducto',
        'nombreProductos',
        'descripcionProductos',
        'precioProductos',
        'estadoProductos',
        'categoriasid',
        'marcasid',
        'unidadesmedidasid',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categorias::class, 'categoriasid', 'idCategorias');
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marcas::class, 'marcasid', 'idMarcas');
    }

    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadesMedidas::class, 'unidadesmedidasid', 'idUnidadesMedidas');
    }

    public function imagenes()
    {
        return $this->hasMany(Imagenes::class, 'productosid', 'idProductos');
    }

    public function stockAlmacen()
    {
        return $this->hasMany(StockAlmacen::class, 'productosid', 'idProductos');
    }
}
