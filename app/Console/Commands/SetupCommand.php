<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        // Firstly run migrations
        $this->call('migrate:fresh');

        // secondly create demo data
        $users = $this->factory(User::class, 10)->create();

        // Create and save demo categories
        $categories = factory(Category::class, 5)->create();

        // For each category, create and save demo posts with comments
        foreach ($categories as $category) {
            $posts = factory(Post::class, 3)->create(['category_id' => $category->id]);

            foreach ($posts as $post) {
                factory(Comment::class, 2)->create(['post_id' => $post->id, 'user_id' => $users->random()->id]);
            }
        }

        $this->info('Demo data populated successfully!');

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
