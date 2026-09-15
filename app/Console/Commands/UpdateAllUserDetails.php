<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class UpdateAllUserDetails extends Command
{
    // The name and signature of the console command
    protected $signature = 'change:user-data';

    // The console command description
    protected $description = 'Update email, username, and phone for all users in the users table';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faker = Faker::create();

        // Fetch all users
        $users = User::all();

        foreach ($users as $user) {
            // Generate random username, first name, and last name
            $randomUsername = $faker->userName;
            $randomEmail = $faker->unique()->email;
            $phone = $faker->unique()->phoneNumber;

            // Generate slug from first name and last name
            $slug = Str::slug($user->firstname . '_' . $user->lastname);

            $slug .= '_' . $this->generateRandomAlphanumeric(3);

            // Update user record
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'username' => $randomUsername,
                    'email' => $randomEmail,
                    'mobile' => $phone,
                    'slug' => $slug
                ]);
        }

        $this->info("User details and slugs updated successfully!");

        return 0;
    }

    private function generateRandomAlphanumeric($length = 6)
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }
}
