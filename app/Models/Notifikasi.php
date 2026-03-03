<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $primaryKey = 'id_notif';

    protected $fillable = [
        'target_id',
        'role_penerima',
        'pesan',
        'is_read'
    ];
}