<?php

use App\NoteBook;
use App\User;
use Illuminate\Database\Seeder;

class NoteBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        $notebooks = factory(NoteBook::class, 10)->make();

        $user->notebooks()->saveMany($notebooks);
    }
}
