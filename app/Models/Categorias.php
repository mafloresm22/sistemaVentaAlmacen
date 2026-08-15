<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorias extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'idCategorias';

    protected $fillable = [
        'nombreCategorias',
        'descripcionCategorias',
        'usersid',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usersid', 'id');
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Productos::class, 'categoriasid', 'idCategorias');
    }
}
