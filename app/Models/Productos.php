<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Productos extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'idProductos';

    protected $fillable = [
        'nombreProductos',
        'descripcionProductos',
        'precioProductos',
        'estadoProductos',
        'categoriasid',
        'marcasid',
        'unidadesmedidasid',
    ];

    /**
     * Relación: un producto pertenece a una categoría.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categorias::class, 'categoriasid', 'idCategorias');
    }

    /**
     * Relación: un producto pertenece a una marca.
     */
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marcas::class, 'marcasid', 'idMarcas');
    }

    /**
     * Relación: un producto tiene una unidad de medida.
     */
    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadesMedidas::class, 'unidadesmedidasid', 'idUnidadesMedidas');
    }
}
