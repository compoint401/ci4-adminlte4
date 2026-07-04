<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,
            'gender',
            'first_name',
            'last_name',
            'avatar',
            'phone_number',
            'company',
            'code_meli',
            'birth_day ',
            'country',
            'state',
            'city',
            'full_address',
            // 'first_name',
        ];
    }
}
