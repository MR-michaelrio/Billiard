<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonMember extends Model
{
    use HasFactory;
    protected $table = 'non_member';
    protected $fillable = ['id', 'nama', 'no_telp'];
}
