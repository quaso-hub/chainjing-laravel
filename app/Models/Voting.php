<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    protected $table = 'voting';

    protected $fillable = ['users_id', 'ruu_id', 'pilihan', 'waktu_vote', 'voting_hash'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function ruu()
    {
        return $this->belongsTo(RUU::class, 'ruu_id');
    }

}
