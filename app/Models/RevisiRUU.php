<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisiRUU extends Model
{
    protected $table = 'revisi_ruu';

    protected $fillable = [
        'user_id',
        'ruu_id',
        'alasan',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruu()
    {
        return $this->belongsTo(RUU::class);
    }
}
