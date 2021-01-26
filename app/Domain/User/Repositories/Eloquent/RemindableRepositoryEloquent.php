<?php

namespace App\Domain\User\Repositories\Eloquent;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\Remindable;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\User\Repositories\Contracts\RemindableRepository;

/**
 * Class RemindableRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RemindableRepositoryEloquent extends EloquentRepository implements RemindableRepository
{
    /**
     * Specify Fields
     *
     * @return string
     */
    protected $allowedFields = [
        ###allowedFields###
        ###\allowedFields###
    ];

    /**
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
        ###allowedIncludes###
        ###\allowedIncludes###
    ];

    /**
     * Complete the process to a specific user.
     *
     * @param User $user
     * @param [string]      $token
     *
     * @return bool|ActivationException|ReminderException
     */
    public function complete(User $user, string $token)
    {
        $remindable = $this->hasToken($user, $token);

        $remindable->token = null;
        $remindable->completed_at = now();

        return $remindable->save();
    }

    /**
     * Check if the user has completed.
     *
     * @param User $user
     *
     * @return bool
     */
    public function completed(User $user, string $type)
    {
        return $user->remindables()->whereNotNull('completed_at')->where(compact('type'))->exists();
    }

    /**
     * generates token for specific user.
     *
     * @param User $user  [description]
     * @param bool|bool     $force [description]
     *
     * @return Illuminate\Database\Eloquent\Model|bool
     */
    public function generateToken(User $user, string $type)
    {
        $remindable = $user->remindables()->where(['completed_at' => null, 'type' => $type])->first();

        if (!$remindable) {
            $remindable = $user->remindables()->create([
                'type' => $type,
                'created_at' => now(),
                'token' => $this->generateTokenBasedOnType($type),
                'expires_at' => now()->addHours(config('semak.remindable.expiration')),
            ]);

        }

        return $remindable;
    }

    /**
     * Retrieves the first applied or token or create new one.
     *
     * @param User $user [description]
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function hasOrCreateToken(User $user, string $type)
    {
        return $this->generateToken($user, $type);
    }

    /**
     * Retrieves the first applied token.
     *
     * @param User $user
     * @param [string]      $token
     *
     * @return Illuminate\Database\Eloquent\Model|null
     */
    public function hasToken(User $user, string $token = null)
    {
        $remindable = $user->remindables()->where(['completed_at' => null, ['expires_at', '>=', now()->subHours(config("semak.remindable.expiration"))->format('Y-m-d H:i')]]);
        if ($token) {
            $remindable->whereToken($token);
        }

        return $remindable->firstOrFail();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Remindable::class;
    }

    /**
     * Regnerates a token for the passed user.
     *
     * @param User $user   [description]
     * @param bool|bool     $create [description]
     *
     * @return Illuminate\Database\Eloquent\Model|bool
     */
    public function regenerateToken(User $user, string $type, bool $create = false)
    {
        if ($create) {
            return $this->generateToken($user, $type);
        }

        if ($remindable = $this->hasToken($user)) {
            $remindable->update([
                'token' => $this->generateTokenBasedOnType($type),
                'completed_at' => null,
                'expires_at' => now()->addHours(config('semak.remindable.expiration')),
                'updated_at' => now(),
            ]);

            return $remindable;
        }
    }

    /**
     * Specify Model Relationships
     *
     * @return string
     */
    public function relations()
    {
        return [
            ###allowedRelations###
            ###\allowedRelations###
        ];
    }

    /**
     * removes expired records which aren't completed yet.
     *
     * @param int|null $hours
     *
     * @return bool
     */
    public function removeExpired(int $hours = null)
    {
        return $this->where(['completed_at' => null, ['expires_at', '<=', now()->subHours($hours ?? config("semak.remindable.expiration"))]])->delete();
    }

    /**
     * @param $type
     */
    private function generateTokenBasedOnType($type)
    {
        switch ($type) {
            case 'activation':
                return mt_rand(10000, 99999);
            case 'reminder':
                return Str::random(32);
            default:
                throw new \Expcetion('Invalid type');
        }
    }
}
