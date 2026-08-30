<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagenes extends Model
{
    protected $primaryKey = 'idImagenes';

    protected $fillable = [
        'nombreImagenes',
        'rutaImagenes',
        'productosid'
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'productosid', 'idProductos');
    }
}
