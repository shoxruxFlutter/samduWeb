<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;

class Kafedra extends Model
{
    use HasFactory;

    protected $table = 'kafedra';
    protected $fillable = ['title', 'fakultet_id'];



    public function teacher()
{
    return $this->belongsToMany(Teacher::class);
}
}
