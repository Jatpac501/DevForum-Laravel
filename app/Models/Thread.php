<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'image_path', 'is_removed', 'is_pin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Answer::class)->latest();
    }

    // лишнее для удаления и восстановления, мог просто выключатель сделать
    public function remove()
    {
        $this->is_removed = true;
        $this->save();
    }

    public function restore()
    {
        $this->is_removed = false;
        $this->save();
    }

    // как я закреп
    public function pin()
    {
        $this->is_pin = !$this->is_pin;
        $this->save();
    }

}
