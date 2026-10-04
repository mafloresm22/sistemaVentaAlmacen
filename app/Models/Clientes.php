<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'idClientes';

    protected $fillable = [
        'nombreClientes',
        'apellidoClientes',
        'tipodocumentoClientes',
        'numerodocumentoClientes',
        'celularClientes',
    ];

    public function ventas()
    {
        return $this->hasMany(Ventas::class, 'clientesid', 'idClientes');
    }
}
