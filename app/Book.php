<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $fillable = ['book_id', 'user_id', 'rating'];
	
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function ratings()
    {
    	return $this->hasMany(Rating::class);
    }
}
