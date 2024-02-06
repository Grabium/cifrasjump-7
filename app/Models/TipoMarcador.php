<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMarcador extends Model
{
    use HasFactory;
    protected $table = 'tipos_marcadores';
    protected $fillable = ['tipo'];

    public function Marcador()
    {
        return $this->hasOne('App\Models\Marcador');
    }
}
