<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedores extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'idProveedores';
    protected $fillable = [
        'nombreProveedores',
        'telefonoProveedores',
        'correoProveedores',
        'direccionProveedores',
        'tipodocumentoProveedores',
        'numerodocumentoProveedores',
        'diasEntregaProveedores',
    ];

    public function compras(): HasMany
    {
        return $this->hasMany(Compras::class, 'proveedoresid', 'idProveedores');
    }
    
}
