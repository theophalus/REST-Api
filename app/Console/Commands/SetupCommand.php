<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;


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


    private $userModel;
    private $postModel;
    private $commentModel;
    private $categoryModel;

    public function __construct(User $userModel, Post $postModel, Comment $commentModel, Category $categoryModel)
    {
        parent::__construct();

        $this->userModel = $userModel;
        $this->postModel = $postModel;
        $this->commentModel = $commentModel;
        $this->categoryModel = $categoryModel;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Firstly check if laravel app key is there, if not generate a new one
        if (!config('app.key')) {
            $this->call('key:generate');
            $this->info('Laravel App key generated successfully!');
        }


        // Secondly run migrations
        $this->call('migrate:fresh');

        // Thirdly create demo data
        $users = User::factory(10)->create();

        // Create and save demo categories
        $categories = Category::factory(5)->create();

        foreach ($categories as $category) {
            $posts = Post::factory(3)->create(['category_id' => $category->id]);
        }

        // create comments
        $comments = Comment::factory(15)->create();

        $this->info('Demo data populated successfully!');


       // Then create a demo user
        $name = $this->ask('Enter a user name?');
        $email = $this->ask('Enter the user email?');
        $password = $this->secret('Enter the user password?');

        $user = \App\Models\User::factory()->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        // Create a sanctum API token
        $token = $user->createToken('Demo Token')->plainTextToken;

        // display created info to the user
        $this->info('Sample user created successfully!');
        $this->info("User email: $email");
        $this->info("Sanctum token created: $token");


    }


}
