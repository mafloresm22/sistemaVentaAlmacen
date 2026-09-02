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

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        $baseUrl = rtrim(env('SUPABASE_URL'), '/');
        $bucket  = config('filesystems.disks.supabase.bucket');
        $path    = ltrim($this->rutaImagenes, '/');

        return "{$baseUrl}/storage/v1/object/public/{$bucket}/{$path}";
    }

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'productosid', 'idProductos');
    }
}
