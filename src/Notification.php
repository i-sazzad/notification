<?php

namespace Ranger\Notification;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $guarded = ['id'];

    public function getToUserIdAttribute($value)
    {
        return explode(',', $value);
    }

}
