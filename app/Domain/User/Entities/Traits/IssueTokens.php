<?php

namespace App\Domain\User\Entities\Traits;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;

/**
 * Issuing Tokens within Activation & Reminder Process.
 */
trait IssueTokens
{
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
        ${$this->process} = $this->hasToken($user, $token);
        ${$this->process}->token = null;
        ${$this->process}->completed_at = now();

        return ${$this->process}->save();
    }

    /**
     * Check if the user has completed.
     *
     * @param User $user
     *
     * @return bool
     */
    public function completed(User $user)
    {
        return $user->{$this->process}()->whereNotNull('completed_at')->exists();
    }

    /**
     * generates token for specific user.
     *
     * @param User $user [description]
     * @param bool|bool $force [description]
     *
     * @return Illuminate\Database\Eloquent\Model|bool
     */
    public function generateToken(User $user)
    {
        $process = $user->{$this->process}()->where(['completed_at' => null])->get();

        if ($process) {
            $process = $user->{$this->process}()->create(['created_at' => now(), 'token' => Str::random(32)]);
        }

        return $process;
    }

    /**
     * Retrieves the first applied or token or create new one.
     *
     * @param User $user [description]
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function hasOrCreateToken(User $user)
    {
        return $this->generateToken($user);
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
        ${$this->process} = $user->{$this->process}()->where(['completed_at' => null, ['created_at', '>=', now()->subDays(config("semak.{$this->process}.expiration"))->format('Y-m-d H:i:s')]]);
        if ($token) {
            ${$this->process}->whereToken($token);
        }

        return ${$this->process}->firstOrFail();
    }

    /**
     * Regnerates a token for the passed user.
     *
     * @param User $user [description]
     * @param bool|bool $create [description]
     *
     * @return Illuminate\Database\Eloquent\Model|bool
     */
    public function regenerateToken(User $user, bool $create = false)
    {
        if ($create) {
            return $this->generateToken($user);
        }

        if (${$this->process} = $this->hasToken($user)) {
            ${$this->process}->update([
                'token' => Str::random(32),
                'completed_at' => null,
                'updated_at' => now(),
            ]);

            return ${$this->process};
        }
    }

    /**
     * removes expired records which aren't completed yet.
     *
     * @param int|null $days
     *
     * @return bool
     */
    public function removeExpired(int $days = null)
    {
        return $this->where(['completed_at' => null, ['created_at', '<=', now()->subDays($days ?? config("sectheater.{$this->process}.expiration"))]])->delete();
    }
}
