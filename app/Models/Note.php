<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['file_note'];
    public function topic() {
        return $this->belongsTo(Topic::class);
    }

    use HasFactory;
}
