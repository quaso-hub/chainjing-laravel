<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RUU extends Model
{
    protected $table = 'ruu';

    protected $fillable = ['judul', 'deskripsi', 'status'];

    public function voting()
    {
        return $this->hasMany(Voting::class, 'ruu_id');
    }

    public function revisi()
    {
        return $this->hasMany(RevisiRUU::class);
    }
}
