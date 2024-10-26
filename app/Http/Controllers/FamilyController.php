<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\HeadService;
use App\Http\Services\FamilyService;
use App\Http\Requests\FamilyRequest;
class FamilyController extends Controller
{
    protected $head,$family;
    public function __construct(HeadService $head,FamilyService $family)
    {
        $this->head = $head;
        $this->family = $family;
    }
    // Famiy Head Listing
    public function index(Request $request){
        $familyHeadList = $this->head->get($request,['parent_id'=>NULL],5);

        return view('frontend.list',compact('familyHeadList'));
    }

    // Add Family Head
    public function addFamilyHead(Request $request){
        return view('frontend.add_head');
    }
    // Save Family Head
    public function saveFamilyHead(FamilyRequest $request){
        $service = $this->head->store($request,'photo','PROFILE_PHOTO');
        return response()->json(['status'=>($service) ? 200 : 400,'msg'=>($service) ? 'Action performed successfully' : 'Something went wrong','url'=>($service) ? route('family.list.view') : '']);
    }
    // Add Family Member
    public function addFamilyMember(Request $request){
        $headId = $request->head_id;
        return view('frontend.members.add_member',compact('headId'));
    }
    // Save Family Member
    public function saveFamilyMember(FamilyRequest $request){
        $service = $this->family->store($request,'photo','PROFILE_PHOTO');
        return response()->json(['status'=>($service) ? 200 : 400,'msg'=>($service) ? 'Action performed successfully' : 'Something went wrong','url'=>($service) ? route('family.list.view') : '']);
    }

    // List of Members
    public function memberLists(Request $request){
        $headId = $request->head_id;
        $familyMemberList = $this->head->get($request,['parent_id'=>$headId],5);
        return view('frontend.members.memberList',compact('familyMemberList'));
    }
}
