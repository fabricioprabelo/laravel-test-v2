<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'Admin';
    case MANAGER = 'Manager';

    public function label(): string
    {
        return match ($this) {
            static::ADMIN => __('roles.admin'),
            static::MANAGER => __('roles.manager'),
        };
    }
}
