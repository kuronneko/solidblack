<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Logger;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Facades\Agent;
use Stevebauman\Location\Facades\Location;
use Stringable;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //protected $fillable = ['user_id','ip','country','city','browser','browser_version','platform','platform_version','agent','host'];
        $user = User::where('name', 'admin2')->first();
        if(!$user){
            $user = User::firstOrCreate([
                'name' => 'admin2',
                'email' => 'admin2@gmail.com',
                'password' => bcrypt('admin2@gmail.com'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'email_verified_at' => now(),
            ]);
        }

        Setting::firstOrCreate([
            'user_id' => $user->id,
            'uuid' => Str::uuid(),
            'slug' => Str::random(20),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        \App\Models\Logger::factory(200)->create();
        //$ip = '200.86.155.87';
/*         Logger::create([
            'user_id' => $user->id,
            'ip' => Location::get($ip)->ip,
            'country' => Location::get($ip)->countryName,
            'city' => Location::get($ip)->cityName,
            'browser' => 'Fx',
            'browser_version' => 'Fx',
            'platform' => 'Fx',
            'platform_version' => 'Fx',
            'agent' => Request::header('user-agent'),
            'host' => gethostbyaddr($ip),

        ]); */

    }
}
