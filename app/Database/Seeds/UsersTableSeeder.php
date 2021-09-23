<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

use App\Models\UserModel;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Time::now();
        $data = [
            [
                'fullname'      => 'Test User 1',
                'email'         => 'test1@example.com',
                'username'      => 'testuser1',
                'password'      => password_hash('12345', PASSWORD_BCRYPT),
                'level'         => 'admin',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'fullname'      => 'Test User 2',
                'email'         => 'test2@example.com',
                'username'      => 'testuser2',
                'password'      => password_hash('12345', PASSWORD_BCRYPT),
                'level'         => 'user',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ]
        ];

        foreach($data as $user)
        {
            $userModel = new UserModel();
            $userModel->insert($user);
        }
    }
}
