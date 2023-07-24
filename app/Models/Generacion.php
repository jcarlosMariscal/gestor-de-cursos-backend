<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generacion extends Model
{
    use HasFactory;
    public $table = "generacions";
    // protected $fillable = array("*");
    protected $fillable = ['nombre','descripcion','fecha_inicio', 'fecha_final','id'];
    public function cursos(){
      return $this->belongsToMany(Curso::class, "curso_estudiante");
    }
}
