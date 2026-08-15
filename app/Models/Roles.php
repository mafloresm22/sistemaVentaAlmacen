<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'idRoles';

    protected $fillable = [
        'nameRoles',
    ];

    /**
     * Relación: un rol tiene muchos usuarios.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'rolesid', 'idRoles');
    }
}
