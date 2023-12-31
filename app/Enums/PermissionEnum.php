<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case USER_READ = 'users:read';
    case USER_CREATE = 'users:create';
    case USER_UPDATE = 'users:update';
    case USER_DELETE = 'users:delete';

    case TEAM_READ = 'teams:read';
    case TEAM_CREATE = 'teams:create';
    case TEAM_UPDATE = 'teams:update';
    case TEAM_DELETE = 'teams:delete';

    case HOTEL_READ = 'hotels:read';
    case HOTEL_CREATE = 'hotels:create';
    case HOTEL_UPDATE = 'hotels:update';
    case HOTEL_DELETE = 'hotels:delete';

    public function label(): string
    {
        return match ($this) {
            static::USER_READ => __('permissions.users-read'),
            static::USER_CREATE => __('permissions.users-create'),
            static::USER_UPDATE => __('permissions.users-update'),
            static::USER_DELETE => __('permissions.users-delete'),

            static::TEAM_READ => __('permissions.teams-read'),
            static::TEAM_CREATE => __('permissions.teams-create'),
            static::TEAM_UPDATE => __('permissions.teams-update'),
            static::TEAM_DELETE => __('permissions.teams-delete'),

            static::HOTEL_READ => __('permissions.hotels-read'),
            static::HOTEL_CREATE => __('permissions.hotels-create'),
            static::HOTEL_UPDATE => __('permissions.hotels-update'),
            static::HOTEL_DELETE => __('permissions.hotels-delete'),
        };
    }
}
