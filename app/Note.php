<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'note_book_id', 'title', 'content'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $appends = [
        'date', 'time'
    ];

    public function getDateAttribute()
    {
        return $this->created_at->format('d F Y');
    }

    public function getTimeAttribute()
    {
        return $this->created_at->format('h:ia');
    }

    public function notebook()
    {
        return $this->belongsTo(NoteBook::class);
    }
}
