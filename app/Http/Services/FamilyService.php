<?php
namespace App\Http\Services;

use App\Models\FamilyHead;
use App\Http\Services\MediaService;
class FamilyService {

    public $media;
    public function __construct(){
        $this->media = new MediaService();
    }
    public function get(Object $request,$condition,  $limit = 10){
        return FamilyHead::with('media')->where($condition)->paginate($limit);
    }
    public function store(Object $request,$file_name = '',$file_tag=''){
        $member =  FamilyHead::create($request->toArray());
        if($file_name != '' && $file_tag != ''){
            $uploaded = $this->media->store($file_name,$file_tag,$request,$member);
        }
        return $member;
    }
}
