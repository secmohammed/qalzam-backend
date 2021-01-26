<?php

namespace App\Domain\User\Entities;

use App\Domain\User\Entities\User;
use App\Infrastructure\AbstractModels\BaseModel as Model;

class DeviceToken extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['token', 'device', 'user_id'];

    /**
     * @var string
     */
    protected $table = 'device_tokens';

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
