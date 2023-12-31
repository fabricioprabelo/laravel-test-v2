<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HotelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasTeamPermission(
            $user?->currentTeam,
            PermissionEnum::HOTEL_READ->value
        ) || $user->tokenCan(PermissionEnum::HOTEL_READ->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hotel $hotel): bool
    {
        return $user->hasTeamPermission(
            $user?->currentTeam,
            PermissionEnum::HOTEL_READ->value
        ) || $user->tokenCan(PermissionEnum::HOTEL_READ->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasTeamPermission(
            $user?->currentTeam,
            PermissionEnum::HOTEL_CREATE->value
        ) || $user->tokenCan(PermissionEnum::HOTEL_CREATE->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hotel $hotel): bool
    {
        return $user->hasTeamPermission(
            $user?->currentTeam,
            PermissionEnum::HOTEL_UPDATE->value
        ) || $user->tokenCan(PermissionEnum::HOTEL_UPDATE->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hotel $hotel): bool
    {
        return $user->hasTeamPermission(
            $user?->currentTeam,
            PermissionEnum::HOTEL_DELETE->value
        ) || $user->tokenCan(PermissionEnum::HOTEL_DELETE->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Hotel $hotel): bool
    {
        return $user->hasTeamPermission(
            $user?->currentTeam,
            PermissionEnum::HOTEL_DELETE->value
        ) || $user->tokenCan(PermissionEnum::HOTEL_DELETE->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Hotel $hotel): bool
    {
        return $user->hasTeamPermission(
            $user?->currentTeam,
            PermissionEnum::HOTEL_DELETE->value
        ) || $user->tokenCan(PermissionEnum::HOTEL_DELETE->value);
    }
}
