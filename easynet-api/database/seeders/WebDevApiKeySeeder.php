<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ApiKeys;

class WebDevApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $token = new ApiKeys;
        $token->user_id = 1;
        $token->token = Str::random(32);
        $token->save();
        $this->command->info("Token has been created");
    }
}
