<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RUU extends Model
{
    protected $table = 'ruu';

    protected $fillable = [
        'judul',
        'deskripsi',
        'user_id',
        'status',
        'voting_mulai',
        'voting_selesai',
    ];

    public function voting()
    {
        return $this->hasMany(Voting::class, 'ruu_id', 'id');
    }

    public function revisi()
    {
        return $this->hasMany(RevisiRUU::class, 'ruu_id', 'id');
    }
}
