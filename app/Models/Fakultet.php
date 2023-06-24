<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kafedra;

class Fakultet extends Model
{
    use HasFactory;

    
    protected $table = 'fakultet';
    protected $fillable = ['title'];




    public function kafedra()
    {
        return $this->belongsTo(Kafedra::class);
    }
}
