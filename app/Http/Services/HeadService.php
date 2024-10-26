<?php
namespace App\Http\Services;

use App\Models\FamilyHead;
use App\Http\Services\MediaService;
class HeadService {

    public $media;
    public function __construct(){
        $this->media = new MediaService();
    }
    public function get(Object $request,$condition,  $limit = 10){
        return FamilyHead::with('media')->withCount('members')->where($condition)->paginate($limit);
    }
    public function store(Object $request,$file_name = '',$file_tag=''){
        $request->merge(['hobbies'=>implode('|',$request->hobbies)]);
        $head =  FamilyHead::create($request->toArray());
        if($file_name != '' && $file_tag != ''){
            $uploaded = $this->media->store($file_name,$file_tag,$request,$head);
        }
        return $head;
    }

}