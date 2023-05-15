<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations, create a demo user, and create a Sanctum API token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Firstly run migrations
        $this->call('migrate');

       // Then create a demo user
        $name = $this->ask('What is the user name?');
        $email = $this->ask('What is the user email?');
        $password = $this->secret('What is the user password?');

        $user = \App\Models\User::factory()->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        // Create the API token
        $token = $user->createToken('Demo Token')->plainTextToken;

        // display created info to the user
        $this->info('Sample user created successfully!');
        $this->info("User email: $email");
        $this->info("Sanctum token created: $token");


    }
}
