<?php

namespace App\Common\Entities;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    /**
     * @var mixed
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
        'payload' => 'array',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'payload',
    ];

    /**
     * @var string
     */
    protected $table = 'jobs';
}
