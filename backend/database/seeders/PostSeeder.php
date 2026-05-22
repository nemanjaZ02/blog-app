<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $alice = User::where('email', 'alice@example.com')->first();
        $bob   = User::where('email', 'bob@example.com')->first();
        $admin = User::where('email', 'admin@example.com')->first();

        $posts = [
            ['user_id' => $alice->id, 'title' => 'My Trip to Japan', 'content' => 'Japan was absolutely amazing. The food, the culture, the people — everything was perfect. I visited Tokyo, Kyoto and Osaka. Would highly recommend to anyone who loves adventure.'],
            ['user_id' => $alice->id, 'title' => 'Best Coffee Shops in Belgrade', 'content' => 'I have been exploring Belgrade cafe scene for months now. Here are my top picks for the best coffee in the city. Spoiler: there are some hidden gems you would never expect.'],
            ['user_id' => $alice->id, 'title' => 'How I Lost 10kg in 3 Months', 'content' => 'It was not easy but it was worth it. I changed my diet, started walking every day and cut out sugar. Here is exactly what I did step by step.'],
            ['user_id' => $alice->id, 'title' => 'Book Review: The Alchemist', 'content' => 'Paulo Coelho wrote something truly special. This book changed the way I think about life and following your dreams. A must read for everyone.'],
            ['user_id' => $alice->id, 'title' => 'Weekend in Novi Sad', 'content' => 'Spent the weekend in Novi Sad and I was blown away. The Exit festival location, the fortress, the food — all incredible. Will definitely go back.'],
            ['user_id' => $alice->id, 'title' => 'My Morning Routine', 'content' => 'I wake up at 6am every day. First thing I do is drink a glass of water, then I meditate for 10 minutes. After that I go for a walk. This routine changed my life.'],
            ['user_id' => $alice->id, 'title' => 'Top 5 Netflix Shows Right Now', 'content' => 'I have been watching a lot of Netflix lately and these 5 shows are absolutely worth your time. From thrillers to comedies, there is something for everyone.'],
            ['user_id' => $bob->id, 'title' => 'Why I Quit My Job', 'content' => 'After 5 years at the same company I decided it was time for a change. It was scary but the best decision I ever made. Here is my story.'],
            ['user_id' => $bob->id, 'title' => 'Cooking Italian Food at Home', 'content' => 'You do not need to go to a fancy restaurant to enjoy great Italian food. With a few simple ingredients you can make restaurant quality pasta at home.'],
            ['user_id' => $bob->id, 'title' => 'My Favorite Hiking Trails', 'content' => 'Serbia has some amazing hiking trails that most people do not know about. I have explored many of them and here are my absolute favorites.'],
            ['user_id' => $bob->id, 'title' => 'Getting a Dog Changed My Life', 'content' => 'I never thought I was a dog person until I got Max. Now I cannot imagine life without him. Here is how having a dog changed my daily routine completely.'],
            ['user_id' => $bob->id, 'title' => 'Budget Travel Tips for Europe', 'content' => 'Traveling Europe does not have to be expensive. I traveled through 8 countries in 30 days spending less than 1000 euros. Here are my best tips.'],
            ['user_id' => $bob->id, 'title' => 'Learning a New Language at 30', 'content' => 'Everyone says it gets harder to learn a language as you get older. I decided to prove them wrong. Here is my journey learning Spanish at age 30.'],
            ['user_id' => $bob->id, 'title' => 'The Best Burgers in Town', 'content' => 'I am on a mission to find the best burger in the city. I have tried over 20 places so far. Here is my honest ranking from worst to best.'],
            ['user_id' => $admin->id, 'title' => 'Why Sleep is More Important Than Exercise', 'content' => 'We all know exercise is important but most people underestimate the power of good sleep. Getting 8 hours changed my energy levels dramatically.'],
            ['user_id' => $admin->id, 'title' => 'My Vinyl Record Collection', 'content' => 'I have been collecting vinyl records for 10 years. There is something magical about the sound of a record player that digital music just cannot replicate.'],
            ['user_id' => $admin->id, 'title' => 'How to Save Money in 2024', 'content' => 'With everything getting more expensive it can feel impossible to save money. But with a few simple tricks I managed to save 20% of my salary every month.'],
            ['user_id' => $admin->id, 'title' => 'City vs Country Living', 'content' => 'I grew up in the country and moved to the city 5 years ago. Both have their pros and cons. Here is my honest take after experiencing both lifestyles.'],
            ['user_id' => $admin->id, 'title' => 'Why I Started Journaling', 'content' => 'I used to think journaling was not for me. Then I tried it for 30 days and it completely changed how I process my thoughts and emotions.'],
            ['user_id' => $admin->id, 'title' => 'The Perfect Chocolate Cake Recipe', 'content' => 'After years of experimenting I finally perfected my chocolate cake recipe. It is moist, rich and absolutely delicious. Here is the full recipe.'],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}