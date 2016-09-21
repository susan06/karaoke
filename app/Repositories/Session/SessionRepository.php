<?php

namespace App\Repositories\Session;

use App\Repositories\RepositoryInterface;

interface SessionRepository extends Repository
{
    /**
     * Get all active sessions for specified user.
     *
     * @param $userId
     * @return mixed
     */
    public function getUserSessions($userId);

    /**
     * Invalidate specified session for provided user
     *
     * @param $userId
     * @param $sessionId
     * @return mixed
     */
    public function invalidateUserSession($userId, $sessionId);
}