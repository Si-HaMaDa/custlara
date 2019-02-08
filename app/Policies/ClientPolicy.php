<?php

namespace App\Policies;

use App\User;
use App\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Client $client)
    {
        return $user->id == $client->respon_id || $client->respon_id == NULL || $user->lvl == 1;
    }

    public function delete(User $user, Client $client)
    {
        return $user->lvl == 1;
    }
}
