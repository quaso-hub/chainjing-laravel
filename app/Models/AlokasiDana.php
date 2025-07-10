<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlokasiDana extends Model
{
    protected $table = 'alokasi_dana';

    protected $fillable = ['nama_program', 'jumlah', 'tanggal', 'keterangan', 'status_blockchain', 'tx_id'];
}
