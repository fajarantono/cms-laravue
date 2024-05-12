<?php

namespace Database\Seeders;

use App\Enums\Ask;
use App\Enums\Role as EnumRole;
use Dipokhalder\EnvEditor\EnvEditor;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\Status;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$envService = new EnvEditor();
        $admin      = User::create([
            'name'              => 'Fajar Antono',
            'email'             => 'fajar.antono988@gmail.com',
            'phone'             => '087776926464',
            'username'          => 'fajarantono',
            'email_verified_at' => now(),
            'password'          => bcrypt('@uburubur256'),
            'branch_id'         => 0,
            'status'            => Status::ACTIVE,
            'country_code'      => '+62',
            'is_guest'          => Ask::NO
        ]);
        $admin->assignRole(EnumRole::ADMIN);

    }
}
