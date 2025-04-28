<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'autors';

    protected $fillable = [
        'nome',
        'email',
        'endereco',
        'cidade',
        'bairro',
        'cep',
        'telefone',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function livros()
    {
        $this->hasMany(Livro::class);
    }
}
