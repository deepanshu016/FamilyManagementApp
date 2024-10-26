<?php
namespace App\Http\Services;

use App\Models\User;
use App\Models\MessOwner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class MediaService {

    public function store($file_name,$file_tag,$request,$model){
        $success = false;
        if($request->hasFile($file_name) && $request->file($file_name)->isValid()){
            $model->addMediaFromRequest($file_name)->toMediaCollection($file_tag);
            $success = true;
        }
        return $success;
    }
 }


?>
