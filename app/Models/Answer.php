<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body', 'user_id', 'thread_id', 'image_path', 'is_removed', 'is_pin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function remove()
    {
        $this->is_removed = !$this->is_removed;
        $this->save();
    }

    public function pin()
    {
        $this->is_pin = !$this->is_pin;
        $this->save();
    }
}
