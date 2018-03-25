<?php
use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Profile;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'User')->first();
        //$role_author = Role::where('name', 'Author')->first();
        $role_admin = Role::where('name', 'Admin')->first();
        
        
        
        $admin = new User();
        $admin->first_name = 'Dylan';
        $admin->last_name = 'Clements';
        $admin->email = 'dylan@gmail.com';
        $admin->password = bcrypt('test');
        $admin->save();
        $admin->roles()->attach($role_admin);
        $profile1 = new Profile();
        $profile1->user()->associate($admin);
        $profile1->save();

        $user = new User();
        $user->first_name = 'Snazzy';
        $user->last_name = 'Suzy';
        $user->email = 'dylan@yahoo.com';
        $user->password = bcrypt('test');
        $user->save();
        $user->roles()->attach($role_user);
        $profile2 = new Profile();
        $profile2->user()->associate($user);
        $profile2->save();
        
        $user2 = new User();
        $user2->first_name = 'Andy';
        $user2->last_name = 'Author';
        $user2->email = 'dylan@hotmail.com';
        $user2->password = bcrypt('test');
        $user2->save();
        $user2->roles()->attach($role_user);
        $profile3 = new Profile();
        $profile3->user()->associate($user2);
        $profile3->save();

    }
}