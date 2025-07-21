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

         // 2. إنشاء الدور
        $role = Role::firstOrCreate(['name' => 'owner']);

        // 3. الحصول على كل الصلاحيات (أو حدد بعضها إن أردت)
        $permissions = Permission::pluck('name')->toArray();

        // 4. ربط الدور بالصلاحيات
        $role->syncPermissions($permissions);

        // 5. ربط المستخدم بالدور
        $user->assignRole('owner');


}
}
