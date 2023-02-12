<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\UserRegistrationModel;
use App\Models\Purchase;

class ContactController extends Controller
{
    function ContactAdd(Request $request){
        date_default_timezone_set("Asia/Dhaka");
        $user_mobile=$request->input('user_mobile');
        $contact_type=$request->input('contact_type');
        $name=$request->input('name');
        $mobile_no=$request->input('mobile_no');
        $email=$request->input('email');
        $address_line_one=$request->input('address_line_one');
        $city=$request->input('city');
        $country=$request->input('country');
        $created_date= date("d-m-Y");
        $created_time= date("h:i:sa");
        $created_by=$request->input('created_by');

        $result= ContactModel::insert([
            'user_mobile'=>$user_mobile,
            'contact_type'=>$contact_type,
            'name'=>$name,
            'mobile_no'=>$mobile_no,
            'email'=>$email,
            'address_line_one'=>$address_line_one,
            'city'=>$city,
            'country'=>$country,
            'created_date'=>$created_date,
            'created_time'=>$created_time,
            'created_by'=>$created_by
        ]);
        return $result;
    }

    function ContactList(Request $request){
        $user_mobile=$request->input('user_mobile');
        $result= ContactModel::where('user_mobile',$user_mobile)->orderBy('name')->get();
        $list =[];
        $totals = [];
        foreach($result as $item){
            $totalPayable = 0;
            $toatalPayment = 0;
            $invoices = Invoice::where('contact_id','=',$item->id)->get();
        
            if($invoices){
               foreach($invoices  as $inv){
                   $totalPayable += $inv->total_payable;
                   $payment = InvoicePayment::where('invoice_id',$inv->invoice_id)->select(\DB::raw('SUM(paymentAmount) as payment'))->first();
                   $toatalPayment += $payment->payment;
               }
            }
            
            $purchase = Purchase::where('supplier_id',$item->id)->select(\DB::raw('SUM(total_purchase) - SUM(total_pay) as dibo'))->first();
            
            
            
            $list[] = [
                'user_mobile'=>$item->mobile_no,
                'id'=>$item->id,
                'contact_type'=>$item->contact_type,
                'name'=>$item->name,
                'mobile_no'=>$item->mobile_no,
                'email'=>$item->email,
                'address_line_one'=>$item->address_line_one,
                'city'=>$item->city,
                'country'=>$item->country,
                'created_date'=>$item->created_date,
                'created_time'=>$item->created_time,
                'created_by'=>$item->created_by,
                'updated_date'=>$item->updated_date,
                'updated_time'=>$item->updated_time,
                'updated_by'=>$item->updated_by,
                //'pabo'=> $totalPayable,
                'pabo'=> ($purchase->dibo < 0) ? ($totalPayable - $toatalPayment) + abs($purchase->dibo)  : $totalPayable - $toatalPayment,
                'dibo'=> ($purchase->dibo > 0) ? $purchase->dibo : 0 
                ];
        }
        return $list;
    }

    function ContactDetails(Request $request){
        $id=$request->input('id');
        $result= ContactModel::where('id',$id)->get();
        return $result;
    }

    function ContactUpdate(Request $request){
        date_default_timezone_set("Asia/Dhaka");

        $id=$request->input('id');
        $contact_type=$request->input('contact_type');
        $name=$request->input('name');
        $mobile_no=$request->input('mobile_no');
        $email=$request->input('email');
        $web_site=$request->input('web_site');
        $address_line_one=$request->input('address_line_one');
        $city=$request->input('city');
        $country=$request->input('country');
        $created_date= date("d-m-Y");
        $created_time= date("h:i:sa");
        $updated_by=$request->input('updated_by');

        $result= ContactModel::where('id',$id)->update([
            'contact_type'=>$contact_type,
            'name'=>$name,
            'mobile_no'=>$mobile_no,
            'email'=>$email,
            'address_line_one'=>$address_line_one,
            'city'=>$city,
            'country'=>$country,
            'updated_date'=>$created_date,
            'updated_time'=>$created_time,
            'updated_by'=>$updated_by
        ]);
        return $result;
    }

    function ContactDelete(Request $request){
        $id=$request->input('id');
        $result=ContactModel::where('id','=',$id)->delete();
        if ($result==true){
            return 1;
        }
        else{
            return 0;
        }
    }
    
   function ContactFilter(Request $request){
        $user_mobile=$request->input('user_mobile');
        $customer=$request->input('customer');
        $delivery_partner=$request->input('delivery_partner');
        $supplier=$request->input('supplier');
        
        /*
        $result1= ContactModel::where('user_mobile', '=',$user_mobile)->where('contact_type', '=', $supplier)->get();
        $result2= ContactModel::where('user_mobile', '=',$user_mobile)->where('contact_type', '=', $delivery_partner)->get();
        $result3= ContactModel::where('user_mobile', '=',$user_mobile)->where('contact_type', '=', $customer)->get();
        $result = $result1->merge($result2)->merge($result3);
        return $result;
        */

        //$user_mobile=$request->input('user_mobile');
       
        $result= ContactModel::orWhere('contact_type', '=', $supplier)->orWhere('contact_type', '=', $delivery_partner)->orWhere('contact_type', '=', $customer)->get();
        $list =[];
        $totals = [];
        foreach($result as $item){
            if($item->user_mobile === $user_mobile){
            
                $totalPayable = 0;
                $toatalPayment = 0;
                $invoices = Invoice::where('contact_id','=',$item->mobile_no)->get();
            
                if($invoices){
                   foreach($invoices  as $inv){
                       $totalPayable += $inv->total_payable;
                       $payment = InvoicePayment::where('invoice_id',$inv->invoice_id)->select(\DB::raw('SUM(paymentAmount) as payment'))->first();
                       $toatalPayment += $payment->payment;
                   }
                }
                
                $purchase = Purchase::where('supplier_id',$item->id)->select(\DB::raw('SUM(total_purchase) - SUM(total_pay) as dibo'))->first();
                
                
                
                $list[] = [
                    'user_mobile'=>$item->mobile_no,
                    'id'=>$item->id,
                    'contact_type'=>$item->contact_type,
                    'name'=>$item->name,
                    'mobile_no'=>$item->mobile_no,
                    'email'=>$item->email,
                    'address_line_one'=>$item->address_line_one,
                    'city'=>$item->city,
                    'country'=>$item->country,
                    'created_date'=>$item->created_date,
                    'created_time'=>$item->created_time,
                    'created_by'=>$item->created_by,
                    'updated_date'=>$item->updated_date,
                    'updated_time'=>$item->updated_time,
                    'updated_by'=>$item->updated_by,
                    'pabo'=> ($purchase->dibo < 0) ? ($totalPayable - $toatalPayment) + abs($purchase->dibo)  : $totalPayable - $toatalPayment,
                    'dibo'=> ($purchase->dibo < 0) ? 0 : $purchase->dibo
                    ];
            
                }
            }
        return $list;
        
        
        

        
    }
    
    function UpdateProfile(Request $request)
    {
        $data = UserRegistrationModel::where('mobile',$request->input('mobile'))->first();
        $mobile = UserRegistrationModel::where('mobile',$request->input('mobile'))->where('id','!=',$data->id)->first();
        if($mobile){
            return response()->json(['message'=>'Mobile already exist']);
        }
        $data->mobile = $request->input('mobile');
        $data->user_full_name = $request->input('full_name');
        $data->business_name = $request->input('business_name');
        $data->save();
        return response()->json(['message'=>'Profile update']);
    }
    
    function getUser(Request $request)
    {
        $data = UserRegistrationModel::where('mobile',$request->input('mobile'))->first();
        return response()->json($data);
    }
    
    function changePassword(Request $request)
    {
        $data = UserRegistrationModel::where('mobile', $request->input('mobile'))->first();
        if ($data) {
            if ($data->password == $request->input('old_password')) {
                $data->password = $request->input('new_password');
                $data->save();
                return response()->json(['message' => 'Password saved successfully']);
            }

            return response()->json(['message' => 'Password is not correct']);
        } else {
            return response()->json(['message' => 'User not found']);
        }
    }
    
    function ExportContact(Request $request){
        $user_number = $request->userNumber;
        $contactList =  ContactModel::where('user_mobile',$user_number)->get();
        return view('ContactList',['contactList' => $contactList]);
    }
        

    
}
