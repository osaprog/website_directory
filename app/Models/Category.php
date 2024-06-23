<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    /**
     * Hide the pivot attribute from the model's JSON form.
     */
    protected $hidden = ['pivot','created_at','updated_at'];

    public function websites()
    {
        return $this->belongsToMany(Website::class);
    }

}
