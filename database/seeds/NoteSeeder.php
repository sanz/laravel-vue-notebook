<?php

use App\NoteBook;
use App\Note;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notebooks = NoteBook::take(10)->get();

        foreach ($notebooks as $notebook) {
            $notes = factory(Note::class, 10)->make();

            $notebook->notes()->saveMany($notes);
        }
    }
}
