<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

   

    /**
     * The roles that belong to the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany(Image::class);
    }

    /**
     * Get the user associated with the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function project_rating()
    {
        return $this->belongsTo(ProjectRating::class , 'rating_id' , 'id');
    }

    public function project_return()
    {
        return $this->belongsTo(ProjectReturn::class  , 'return_id' , 'id');
    }
    public function project_str()
    {
        return $this->belongsTo(ProjectStructure::class  , 'str_id' , 'id');
    }
    public function project_type()
    {
        return $this->belongsTo(ProjectType::class , 'type_id' , 'id');
    }

}
