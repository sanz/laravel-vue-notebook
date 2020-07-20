<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteBook extends Model
{
    public static function booted()
    {
        static::deleting(function ($notebook) {
            $notebook->notes()->delete();
        });
    }

    protected $fillable = [
        'user_id', 'title'
    ];

    protected $hidden = [
        'user_id', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public static function userNotebooks()
    {
        return static::where('user_id', auth()->id())->latest()->get();
    }
}
