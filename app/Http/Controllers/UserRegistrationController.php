<?php

namespace App\Http\Controllers;
use App\Models\OtpModel;
use App\Models\UserRegistrationModel;
use App\Models\DefaultValueModel;
use Illuminate\Http\Request;



class UserRegistrationController extends Controller
{

    function CreateOTP(Request $request){
        date_default_timezone_set("Asia/Dhaka");
        $mobile=$request->input('mobile');
        $digit_random_number = mt_rand(1000, 9999);
        $smsBody= $digit_random_number." আপনার হিসাব বন্ধুর ভেরিফিকেশন কোড।";
        $created_timestamp=time();
        $created_time= date("h:i:sa");
        $created_date= date("d-m-Y");
        $check=UserRegistrationModel::where('mobile',$mobile)->count();
        if ($check>0){
            return "exist";
        }
        else{
        $sendSMS= SMSClass::CreateSMS( $mobile,$smsBody);
        $result= OtpModel::insert([
                'mobile'=>$mobile,
                'otp'=>$digit_random_number,
                'created_timestamp'=>$created_timestamp,
                'created_date'=>$created_date,
                'created_time'=>$created_time,
            ]);
        return $result;
        }
        
    }
    
    function OtpVerification(Request $request){
        $otp=$request->input('otp');
        $mobile=$request->input('mobile');
        $countNo= OtpModel::Where('mobile',$mobile)->Where('otp',$otp)->count();
        if($countNo>0){
            return 1;
        }
        else{
            return 0;
        }
    }


    function UserRegistration(Request $request){
        date_default_timezone_set("Asia/Dhaka");
        $input = [
                'mobile'=> $request->input('mobile'),
                'user_full_name'=> $request->input('user_full_name'),
                'business_name'=> $request->input('business_name'),
                'password'=> $request->input('password'),
                'created_date'=>date("d-m-Y"),
                'created_time'=>date("h:i:sa")
            ];
        
        $check=UserRegistrationModel::where('mobile',$request->input('mobile'))->count();
        if ($check>0){
            return "exist";
        }
        else{
            $result=UserRegistrationModel::insert($input);
            
            $defaultValue = DefaultValueModel::insert([
                    "user_mobile" =>  $request->input('mobile'),
                    "created_at" => time()
                ]);
            
            if($result && $defaultValue){
                return $result;
            }else{
                return false;
            }
            
        }
    }
    
    function updateProfile(Request $request){
        date_default_timezone_set("Asia/Dhaka");
        $input = [
                'user_full_name'=> $request->input('user_full_name'),
                'business_name'=> $request->input('business_name'),
                'address' => $request->input('address'),
                'email' => $request->input('email'), 
                'business_phone' => $request->input('business_phone'),
                'website' => $request->input('website'),
                'facebook_link' => $request->input('facebook_link'),
                'bus_reg_no' => $request->input('reg_no'),
                'bus_vat_no' => $request->input('vat_no'),
                'company_logo' => $request->input('company_logo')
            ];
        
            $result=UserRegistrationModel::where('mobile',$request->input('mobile'))->update($input);
            if($result){
                 return response()->json(['message'=>'Profile update']);
            }
           
    }


    function UserLogin(Request $request){
        $mobile=$request->input('mobile');
        $password=$request->input('password');
        $userCount=UserRegistrationModel::where('mobile',$mobile)->where('password',$password)->count();
        if ($userCount==1){
            
            $result= UserRegistrationModel::where('mobile',$mobile)->where('password',$password)->first();
            $data =  DefaultValueModel::where('user_mobile', $mobile)->first();
            
            if($result && $data){
                 return response()->json([$result,$data]);
            }else{
                return 0;
            }
           
        }
        else{
            return 0;
        }
    }
    
    function CheckUser(Request $request){
        $mobile=$request->input('mobile');
        $userCount=UserRegistrationModel::where('mobile',$mobile)->count();
        if ($userCount==1){
        date_default_timezone_set("Asia/Dhaka");
        $mobile=$request->input('mobile');
        $digit_random_number = mt_rand(1000, 9999);
        $smsBody="হিসাব বন্ধুর প্রিয় গ্রাহক আপন ৪ সংখ্যার ভেরিফিকেশন পিন ". $digit_random_number;
        $created_timestamp=time();
        $created_time= date("h:i:sa");
        $created_date= date("d-m-Y");
            
        $sendSMS= SMSClass::CreateSMS( $mobile,$smsBody);
        $result= OtpModel::insert([
                'mobile'=>$mobile,
                'otp'=>$digit_random_number,
                'created_timestamp'=>$created_timestamp,
                'created_date'=>$created_date,
                'created_time'=>$created_time,
            ]);
        return $result;
        }
        else{
            return "not_exist";
        }
    }
    
    function UpdatePassword(Request $request){
        $mobile=$request->input('mobile');
        $password=$request->input('password');
        $result=UserRegistrationModel::where('mobile',$mobile)->update(['password'=>$password]);
        return $result;
    }
    
    
    function getDefaultValue(Request $request){
        $data =  DefaultValueModel::where('user_mobile', $request->mobile)->first();
        return response()->json($data);
    }
    
    
    function updateDefaultValue(Request $request){
        $mobile = $request->input('mobile');
        $input = [
                "service_charge" => $request->service_charge,
                "delivery_charge" => $request->delivery_charge,
                "vat" => $request->vat,
                "invoice_end_date" => $request->invoice_end_date,
                "updated_at" => time()
            ];
            
        $result = DefaultValueModel::where('user_mobile', $request->mobile)->update($input);
        if($result){
            return response()->json(['message'=>'Value updated']);
        }else{
            return response()->json(['message'=>'Value updated Faild']); 
        }
    }
    
    
    
    
    
    
    
    
    
   
    
    

}
