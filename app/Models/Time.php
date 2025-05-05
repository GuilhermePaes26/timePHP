<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = ['nome', 'titulos', 'imagem'];

    public function jogadores()
    {
        return $this->hasMany(Jogador::class);
    }
}

