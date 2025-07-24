<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{

    $user = User::create([
        'name' => 'samirgamal',
        'email' => 'samir.gamal77@yahoo.com',
        'password' => bcrypt('123456'),
        'Status' => 'مفعل',
    ]);

    // تأكد من استخدام نفس الـ guard_name
    $role = Role::firstOrCreate(
        ['name' => 'owner'],
        ['guard_name' => 'web']
    );

    // جلب صلاحيات بنفس الحارس
    $permissions = Permission::where('guard_name', 'web')->pluck('name')->toArray();

    // ربط الدور بالصلاحيات
    $role->syncPermissions($permissions);

    // ربط المستخدم بالدور
    $user->assignRole($role);

}
}
