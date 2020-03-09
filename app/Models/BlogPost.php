<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Components\Image;
use App\Models\Components\Slug;
//use Kalnoy\Nestedset\NodeTrait;

class BlogPost extends Model
{

    use Image;
    use Slug;

    const UPLOAD_DIRECTORY = 'uploads/blogposts/';

    protected $fillable = [
        'ru_short_content', 'uz_short_content', 'en_short_content',
        'meta_title', 'meta_description', 'meta_keywords',
        'ru_content', 'uz_content', 'en_content',
        'ru_title', 'en_title', 'uz_title',
        'ru_slug', 'en_slug', 'uz_slug',
    ];

    /**
     * @return bool
     */
    public function hasParentCategory()
    {
        return ($this->parentCategory != null) ? true : false;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return strip_tags($this->ru_title);
    }

    public function getShortContent()
    {
        return strip_tags(($this->ru_short_content));
    }

}