<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use Notifiable;
    use SoftDeletes; 
    protected $fillable = [ 'email' ,'email_token'];
}
