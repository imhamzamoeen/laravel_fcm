<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginInfo extends Model
{
    protected $table = 'user_login_info';

    use HasFactory;

    protected $fillable = ['user_id', 'device_name', 'device_type', 'browser', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
