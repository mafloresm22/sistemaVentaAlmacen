<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marcas extends Model
{
  protected $primaryKey = 'idMarcas';

  protected $fillable = [
    'nameMarcas'
  ];

  public function productos()
  {
    return $this->hasMany(Productos::class, 'idMarcas');
  }
}