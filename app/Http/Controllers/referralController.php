<?php

namespace App\Http\Controllers;
use App\Models;
use DB;
use App\Models\referralEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class referralController extends Controller
{
    /** Referral View for User **/ 
 protected function refferalView(){
    
    $respose = array();
    $userId = auth()->id();
    $respose['data'] = referralEmail::select()->where('user_id',$userId)->get()->toArray();
    $count = referralEmail::where('user_id',$userId)->count('refferal_email');
    // config('view.max-referrals') :: count of referrals Max referral manage by Config.
    $respose['fieldCount'] = config('view.max-referrals') - $count;  
    return view('dashboard/form')->with($respose);

 }

/** Ajax Hit for check Email validation **/ 
protected function validateEmail(Request $res)
 {
    
    $validator = Validator::make($res->all(), [
        'email' => 'email',
    ]);

    if ($validator->fails()) {
                return json_encode(['msg' => 'Enter Valid Email ID','status'=>700]);
    }else{
        // Check:: email is already register 
        $result = user::where('email',$res['email'])->count();   
        if($result!=0){
            return json_encode(['msg' => 'Email id is already Register','status'=>700]); 
        }
        // Check:: email referral already sent 
        $result = referralEmail::where('refferal_email',$res['email'])->count('refferal_email');   
        if($result!=0){
            return json_encode(['msg' => 'Referral Already Sent','status'=>700]); 
        }
        return json_encode(['msg' => 'Email Valid','status'=>200]);    
    }
 }


/* Save Referrals from input Box */
protected function referralsEmailSave(Request $res)
 {

    if(gettype($res['referralEmail'])!='array'){
        return back()->with('inserterror','Wrong Input');
        exit('variables are equal');
    }
    // Validation All emails enter in inputbox.
    $emails = $this->checkMailId($res['referralEmail']);

    $insertValue = array();
    $userId = auth()->id();
    foreach($emails as $res){

         array_push($insertValue,['user_id'=>$userId,'profile_created'=>0,'refferal_email'=>$res,'send_status'=>0,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        /** We can sent the mail from here too ***/ 
        // $ress =$this->referralEmailTrigger($res);

    }

    $data = referralEmail::insert($insertValue);
    if($data)
        return back()->with('success','Refferals Will Send In A Mintue!');
    else
        return back()->with('inserterror','We are getting some error.');
 }

 private function checkMailId($emails){
    
    $emails = array_unique(array_filter($emails)); // Senitization :: remove dupliacte and
   // BackEnd Checks of No duplicate referral sent
   
    // Getting all email id from user and referral sent.
    $emailSet1 = referralEmail::pluck('refferal_email')->toArray();
    $emailSet2 = User::pluck('email')->toArray();
    $emailSet = array_merge($emailSet1,$emailSet2);
    // remove if email already exist in $emailSet Array.
    $arrayExists = array_intersect($emails,$emailSet);
    if(!empty($arrayExists))
    {
        foreach($arrayExists as $key=>$val)
        {
         unset($emails[$key]);
        }
    }

	return $emails;

 }
// Mail Trigger If we want to send mail at same time at email enter into DB.(Not in use)
/* protected function referralEmailTrigger($to){

    $first_name = auth()->user()->name;
    $subject = $first_name.' recommends ContactOut';
    $referral_link = url('/register?referral='.base64_encode(auth()->id()));
    
    try {
      $res =  \Mail::send(['html'=>'emailTemplates.referral'],['referral_link' => $referral_link,'first_name'=>$first_name],function($message) use ($subject,$to){
            $message->to($to);
            $message->subject($subject);
            $message->from('vishwakirtimaster@gmail.com','ContactOut');
        });
        return '';
    }catch (\Exception $e) {
        $error = $e->getMessage();
        return json_encode($error);
    }
 }*/

protected function AdminRefferals(Request $res){

    if($res->token=='5X1TgFpjzZKtwEwRiPsmQzIj688yPUcW'){
    // Get all the data from referral sent.
    $response['data'] =  $result = \DB::table('referral_emails')
    ->select('usr.name as sender_name','referral_emails.*')
    ->leftjoin('users as usr','referral_emails.user_id','usr.id')
    ->get()
    ->toArray();
    
    return view('dashboard/adminPortal')->with($response);
 }else{
     return 'You are at wrong place';
 }
}


// This Function Was make if we want add more validation on Referral link. (Not In Use)
/*public function ValidateLink(Request $data){


 $validator =  Validator::make($data->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:4', 'confirmed'],
    ]);
    if ($validator->fails()) {
        return back()->withErrors($validator);
    }
    
    // This is Login through the Referral Llink               
    if(!empty($data->referral_code)){
        $referral_code_Save = referralEmail::where(['profile_created'=>0,'id'=>$rr])->first();
        
        if(!empty($referral_code_Save->user_id)){
            $referral_code_Save->profile_created = 1;
            $referral_code_Save->save();

            $referral_code_Save->user_id = 2;
            $referral_code = User::where('id',3)->first();
            $referral_code->referral_count++;
            $referral_code->save();
        }
        
    }
     User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    return redirect('referrals');    
}*/

}

