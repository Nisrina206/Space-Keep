<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $primaryKey = 'id_notif';

    protected $fillable = [
        'pengirim_id',
    'target_id',
    'role_penerima',
    'judul',
    'pesan',
    'link',
    'is_read'
    ];
}