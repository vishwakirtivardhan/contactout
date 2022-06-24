<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\referralEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class triggerReferralMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Mail:referralEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->triggerMail();
    }
    
    protected function triggerMail(){

        $result = \DB::table('referral_emails')
        ->select('usr.name as sender_name','referral_emails.*')
        ->leftjoin('users as usr','referral_emails.user_id','usr.id')
        ->where('referral_emails.send_status',0)
        ->get()
        ->toArray();
     
        if(!empty($result)){
            foreach($result as $res){
                $response = $this->referralEmailTrigger($res->refferal_email,$res->id,$res->sender_name);
                // print_r($response);die;
                if($response=='success'){
                    $referral_code_Save = referralEmail::find($res->id);
                    $referral_code_Save->send_status = 1;
                    $referral_code_Save->save();
                } 
            }
        }

    }

    private function referralEmailTrigger($to,$id,$first_name){


        $subject = $first_name.' recommends ContactOut';
        $referral_link = 'http://3.210.11.213/contactout-main/index.php/register?referral='.base64_encode($id);
        
        try {
          $res =  \Mail::send(['html'=>'emailTemplates.referral'],['referral_link' => $referral_link,'first_name'=>$first_name],function($message) use ($subject,$to){
                $message->to($to);
                $message->subject($subject);
                $message->from('vishwakirtimaster@gmail.com','ContactOut');
            });

            return 'success';            

        }catch (\Exception $e) {
            $error = $e->getMessage();
            return json_encode($error);
        }
    // die('hehe');
     }
}
