<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model {
    protected $attributes = array(
        'reward' => '',
    );

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}