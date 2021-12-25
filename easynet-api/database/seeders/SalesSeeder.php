<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sales = new User;
        $sales->name = "sales easynet1";
        $sales->email = "sales_easynet1@easynet.id";
        $sales->phone = "6288222668778";
        $sales->roles = json_encode(["SALES"]);
        $sales->photo = NULL;
        $sales->password = \Hash::make("123654Bismillah");
        $sales->status = "ACTIVE";
        $sales->city = "Bandung";
        $sales->province = "Jawa Barat";
        $sales->login = 0;
        $sales->username = trim(preg_replace('/\s+/', '_', $sales->name));
        $sales->save();
        $sales_profile = new Profile;
        $sales_profile->address = 'Jl. Taman Kopo Indah 3 Blk. E No.73, Rahayu,Kec. Margaasih, Kabupaten Bandung, Jawa Barat';
        $sales_profile->post_code = '40218';
        $sales_profile->save();
        $sales->profiles()->sync($sales_profile->id);
        $this->command->info("User admin created successfully");

    }
}
