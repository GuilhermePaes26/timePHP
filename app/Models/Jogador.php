<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Jogador extends Model

{

    protected $fillable = ['nome', 'idade', 'imagem', 'time_id'];
 
    public function time()
    {
        return $this->belongsTo(Time::class);

    }
}

 
