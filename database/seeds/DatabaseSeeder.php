<?php

use App\Note;
use App\NoteBook;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            NoteBookSeeder::class,
            NoteSeeder::class
        ]);
    }
}
