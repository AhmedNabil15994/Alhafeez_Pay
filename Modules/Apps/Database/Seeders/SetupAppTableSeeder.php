<?php

namespace Modules\Apps\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\Donations\Entities\DonationStatus;
use Modules\Authorization\Database\Seeders\RoleSeederTableSeeder;
use Modules\Authorization\Database\Seeders\PermissionsSeederTableSeeder;

class SetupAppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        Model::unguard();
        (new PermissionsSeederTableSeeder())->run();
        (new RoleSeederTableSeeder())->run();
        $this->insertUserRole($this->insertUser());
        DB::commit();
    }

    private function insertUser()
    {
        return User::create([
            'name' => 'admin',
            'mobile' => '01234567891',
            'email' => 'admin@tocaan.com',
            'password' => bcrypt("123456"),
            "type"     => UserType::ADMIN
        ]);
    }

    private function insertUserRole($user)
    {
        $user->assignRole(['super-admin']);
    }
}
