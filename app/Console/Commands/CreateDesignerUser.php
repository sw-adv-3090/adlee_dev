<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;

class CreateDesignerUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-designer-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Role::updateOrCreate(['id' => 4], ['name' => 'Designer']);


        User::updateOrCreate([
            'email' => 'desinger@adlee.io',
        ], [
            'role_id' => UserRole::Designer->value,
            'name' => 'Designer',
            'email' => 'designer@adlee.io',
            'password' => Hash::make('designer@adlee.io'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->info('Designer user created successfully.');
    }
}
