<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class FamilyHead extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name','parent_id','surname','dob','mobile','address','state','city','pincode','marital_status','wedding_date','hobbies'];
    protected $appends = ['full_name','medias'];


    public function head()
    {
        return $this->belongsTo(FamilyHead::class, 'parent_id');
    }

    public function members()
    {
        return $this->hasMany(FamilyHead::class, 'parent_id');
    }


    public function getFullNameAttribute(){
        return $this->name.' '.$this->surname;
    }

    public function getMaritalStatusAttribute($value){
        return ucfirst($value);
    }

    public function getDobAttribute($value){
        return date('j F Y',strtotime($value));
    }

    protected function getMediasAttribute()
    {
        $media = $this->getMedia("PROFILE_PHOTO")->first();
        if ($media) {
            return asset('media/') . '/' . $media->id . '/' . $media->file_name;
        }
        return null;
    }

}
