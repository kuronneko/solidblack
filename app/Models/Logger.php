<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logger extends Model
{
    protected $table = 'logger';

    use HasFactory;

    protected $fillable = ['user_id','ip','country','city','browser','browser_version','platform','platform_version','agent','host', 'created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
