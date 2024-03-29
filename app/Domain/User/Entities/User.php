<?php

namespace App\Domain\User\Entities;

use App\Domain\User\Entities\Traits\CustomAttributes\UserAttributes;
use App\Domain\User\Entities\Traits\Relations\UserRelations;
use App\Domain\User\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use JWTAuth;
use Joovlly\Authorizable\Models\User as Authenticatable;
use Joovlly\Authorizable\Traits\Authorizable;
use Joovlly\Translatable\Traits\Translatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, HasMedia
{
    use Notifiable, UserRelations, UserAttributes, HasFactory, Authorizable, InteractsWithMedia, Translatable, LogsActivity;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'social' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'type',
        'national_id',
        'mobile',
        'status',
        'default_language',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_token',
    ];

    /**
     * @var array
     */
    protected static $logAttributesToIgnore = ['password'];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'User';

    /**
     * @var mixed
     */
    protected static $logOnlyDirty = true;

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = UserRepository::class;

    /**
     * @var mixed
     */
    protected static $submitEmptyLogs = false;

    /**
     * @var array
     */
    protected static $translatables = ['name'];

    /**
     * @return mixed
     */
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function generateAuthToken()
    {
        return JWTAuth::fromUser($this);
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Retrieves the first applied token.
     *
     * @param User $user
     * @param [string]      $token
     *
     * @return Illuminate\Database\Eloquent\Model|null
     */
    public function hasToken(string $token = null)
    {
        $remindable = $this->remindables()->where(['completed_at' => null, ['expires_at', '>=', now()->subHours(config("qalzam.remindable.expiration"))->format('Y-m-d H:i')]]);
        if ($token) {
            $remindable->whereToken($token);
        }

        return $remindable->firstOrFail();
    }
    public function scopeDefaultAddress(Builder $builder)
    {
        return $builder->with(['addresses' => function ($query) {
            $query->where('default', true)->limit(1);
        }]);
    }
    public function scopeHasRole(Builder $builder, $role)
    {
        return $builder->whereHas('roles', function ($query) use ($role) {
            $query->where('slug', $role);
        });
    }
    public static function newFactory()
    {
        self::flushEventListeners();

        return app(\App\Domain\User\Database\Factories\UserFactory::class)->new();
    }
    /**
     * Specifies the user's FCM token
     *
     * @return string
     */
    public function routeNotificationForFcm()
    {
        return $this->deviceTokens()->pluck('token')->toArray();
    }
}
