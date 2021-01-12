<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
    public function education(){
        return $this->hasMany('App\Models\EducationDetail', 'profile_id');
    }
    public function experience(){
        return $this->hasMany('App\Models\WorkExperience', 'profile_id');
    }
    public function languageknown(){
        return $this->hasMany('App\Models\LanguageKnown', 'profile_id');
    }
    public function technologyknown(){
        return $this->hasMany('App\Models\TechnologyKnown', 'profile_id');
    }
    public function reference(){
        return $this->hasMany('App\Models\Reference', 'profile_id');
    }
    public function location(){
        return $this->hasMany('App\Models\Location', 'profile_id');
    }
}
