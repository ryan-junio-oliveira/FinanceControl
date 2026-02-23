<?php

namespace App\Modules\Organization\Application\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Modules\Shared\Presentation\Notifications\InviteNotification;

class OrganizationInviteService
{
    /**
     * Create an invited user with a temporary password and send a notification.
     */
    public function invite(string $username, string $email, int $organizationId): User
    {
        $password = Str::random(12);

        $user = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'organization_id' => $organizationId,
            'must_change_password' => true,
        ]);

        // every invited user is a regular member
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('member');
        }

        // Best-effort notification (silently ignore mail failures in service)
        try {
            $user->notify(new InviteNotification($password));
        } catch (\Throwable $e) {
            // noop
        }

        return $user;
    }
}
