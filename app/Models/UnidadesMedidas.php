<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadesMedidas extends Model
{
    protected $table = 'unidades_medidas';

    protected $primaryKey = 'idUnidadesMedidas';

    protected $fillable = [
        'nameUnidadesMedidas',
        'simboloUnMedidas',
        'permiteDecimalesUnMedidas',
    ];

    public function productos()
    {
        return $this->hasMany(Productos::class, 'unidadesmedidasid', 'idUnidadesMedidas');
    }
}