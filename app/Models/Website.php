<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Website extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'url', 'category_id','description', 'user_id'];

    /**
     * Hide the pivot attribute from the model's JSON form.
     */
    protected $hidden = ['pivot'];

    /**
     * The categories that belong to the website.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_website', 'website_id', 'category_id')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        $array['categories'] = $this->categories();
        $array['votes_count'] = $this->votes()->count();

        return [
            'id' => $array['id'],
            'name' => $array['name'],
            'url' => $array['url'],
            'description' => $array['description'],
            'categories' => $array['categories'],
            'votes_count' => $array['votes_count'],
        ];
    }
}
