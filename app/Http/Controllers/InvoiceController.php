<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\InvoicePayment;
use App\Models\UserRegistrationModel;

class InvoiceController extends Controller
{
    public function storeInvoice(Request $request)
    {
        $response = $this->store($request);
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->data);
        $invoice = Invoice::where('invoice_id', $data->invoice_id)->first();
        if ($invoice) {
            return [
                'message' => 'Invoice id already exist'
            ];
        }
        try {
            $this->saveInvoiceData($data);
            $this->saveInvoiceProduct($data->product_array, $data->invoice_id);
            $this->saveInvoicePayment($data->payment_array, $data->invoice_id);
            return [
                "message" => "Successfully saved"
            ];
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function saveInvoiceData($data)
    {
        $invoice = new Invoice();
        $invoice->invoice_id = $data->invoice_id;
        $invoice->user_number = $data->user_number;
        $invoice->contact_id = $data->contact_id;
        $invoice->contact_name = $data->contact_name;
        $invoice->contact_address = $data->contact_address;
        $invoice->contact_number = $data->contact_number;
        $invoice->invoice_date = $data->invoice_date;
        $invoice->invoice_date_calc = date('Y-m-d',$this->convertDate($data->invoice_date));
        $invoice->invoice_due_date = $data->invoice_due_date;
        $invoice->invoice_desc = $data->invoice_desc;
        $invoice->delivery_status = $data->delivery_status;
        $invoice->delivery_partner_name = $data->delivery_partner_name;
        $invoice->delivery_partner_code = $data->delivery_partner_code;
        $invoice->service_charge = $data->service_charge;
        $invoice->delivery_charge = $data->delivery_charge;
        $invoice->vat = $data->vat;
        $invoice->total_payable = $data->total_payable;
        $invoice->save();
    }

    public function saveInvoiceProduct($data, $invoiceId)
    {
        foreach ($data as $item) {
            $product = new InvoiceProduct();
            $product->invoice_id = $invoiceId;
            $product->productCode = $item->productCode;
            $product->productName = $item->productName;
            $product->productQuantity = $item->productQuantity;
            $product->productUnit = $item->productUnit;
            $product->sellPrice = $item->sellPrice;
            $product->discount = $item->discount;
            $product->description = $item->description;
            $product->totalSellprice = $item->totalSellprice;
            $product->buyPrice = $item->buyPrice;
            $product->discountType = $item->discountType;
            $product->productType = $item->productType;
            $product->discountPercent = $item->discountPercent;
            $product->discountFlat = $item->discountFlat;
            $product->save();
        }
    }

    public function saveInvoicePayment($data, $invoiceId)
    {
        foreach ($data as $item) {
            $payment = new InvoicePayment();
            $payment->invoice_id = $invoiceId;
            $payment->paymentDate = $item->paymentDate;
            $payment->paymentAmount = $item->paymentAmount;
            $payment->paymentDesc = $item->paymentDesc;
            $payment->save();
        }
    }

    public function getInvoice(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $invoice = Invoice::where('invoice_id', $invoice_id)->first();
        $invoiceProduct = InvoiceProduct::where('invoice_id', $invoice_id)->get();
        $invoicePayment = InvoicePayment::where('invoice_id', $invoice_id)->get();
        $invoice['product_array'] = $invoiceProduct;
        $invoice['payment_array'] = $invoicePayment;
        return response()->json($invoice);
    }
    
    public function getInvoicePrint(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $info = Invoice::where('invoice_id', $invoice_id)->first();
        $invoiceProduct = InvoiceProduct::where('invoice_id', $invoice_id)->get();
        $invoicePayment = InvoicePayment::where('invoice_id', $invoice_id)->get();  
        //$user =UserRegistrationModel::where('mobile',$info->user_number)->first();
        $user =UserRegistrationModel::where('mobile', $info->user_number)->first();
        $invoice['info'] = $info;
        $invoice['product_array'] = $invoiceProduct;
        $invoice['payment_array'] = $invoicePayment;
        $invoice['user'] = $user;
        //return response()->json($invoice);
        return view('Invoice', $invoice);
    }

    public function updateInvoice(Request $request)
    {
        $invoice_id = $request->invoice_id;
        try {
            $invoice = Invoice::where('invoice_id', $invoice_id)->first();
            InvoiceProduct::where('invoice_id', $invoice_id)->delete();
            InvoicePayment::where('invoice_id', $invoice_id)->delete();
            isset($invoice) ? $invoice->delete() : "";
            $response = $this->store($request);
            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function deleteInvoice(Request $request)
    {
        $invoice_id = $request->invoice_id;
        try {
            $invoice = Invoice::where('invoice_id', $invoice_id)->first();
            if ($invoice) {
                $invoice->delete();
                InvoiceProduct::where('invoice_id', $invoice_id)->delete();
                InvoicePayment::where('invoice_id', $invoice_id)->delete();
                return response()->json([
                    'message' => 'Deleted Successfully'
                ]);
            } else {
                return response()->json([
                    'message' => 'data not found'
                ]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function getInvoiceList(Request $request)
    {
        $contactNumber = $request->user_number;
        $invoiceList = Invoice::where('user_number', $contactNumber)->orderBy('created_at','desc')->leftJoin('invoice_payments','invoices.invoice_id','invoice_payments.invoice_id')->select(\DB::raw('invoices.*, sum(invoice_payments.paymentAmount) as payment'))->groupBy('invoice_id')->get();
        return response()->json($invoiceList);
    }

    public function filter(Request $request)
    {
        $user_mobile = $request->user_mobile;
        $new_order = $request->new_order;
        $goods_ready = $request->goods_ready;
        $picked_for_delivery = $request->picked_for_delivery;
        $delivered = $request->delivered;
        $statusArray = [$goods_ready,$picked_for_delivery,$delivered,$new_order];
        
        $invoice = Invoice::where('user_number', $user_mobile)
            ->whereIn('delivery_status', $statusArray)
            ->orderBy('created_at', 'desc')->get();
        if(count($invoice) < 1){
            return [];
        }else{
            $filter = [];
            for($i = 0; $i < count($invoice); $i++){
                $invoice_id = $invoice[$i]->invoice_id;
                
                $payment = InvoicePayment::where('invoice_id',$invoice_id)->get(['paymentAmount']);
                $total_pay = 0;
                
                
                if(count($payment) < 1){
                     $total_pay = 0;
                }else{
                    for($j = 0;$j < count($payment); $j++){
                        $total_pay += $payment[$j]->paymentAmount;
                    }
                }
                
                
                $filter[] = [
                        "id" => $invoice[$i]->id,
                        "invoice_id" =>  $invoice_id,
                        "user_number" => $invoice[$i]->user_number,
                        "contact_id" => $invoice[$i]->user_number,
                        "contact_name" => $invoice[$i]->contact_name,
                        "contact_address" => $invoice[$i]->contact_address,
                        "contact_number" => $invoice[$i]->contact_number,
                        "delivery_status" => $invoice[$i]->delivery_status,
                        "invoice_date" => $invoice[$i]->invoice_date,
                        "invoice_due_date" => $invoice[$i]->invoice_due_date,
                        "invoice_desc" => $invoice[$i]->invoice_desc,
                        "delivery_partner_name" => $invoice[$i]->delivery_partner_name,
                        "delivery_partner_code" => $invoice[$i]->delivery_partner_code,
                        "service_charge" => $invoice[$i]->service_charge,
                        "delivery_charge" => $invoice[$i]->delivery_charge,
                        "total_payable" => $invoice[$i]->total_payable,
                        "vat"  => $invoice[$i]->vat,
                        "created_at"  => $invoice[$i]->created_at,
                        "updated_at" => $invoice[$i]->updated_at,
                        "payment" =>$total_pay
                    ];
            }
            
            return $filter;
        }
    }
    
    
    public function filterWithPay(Request $request){
        $status['open'] = $request->open;
        $status['part_paid'] = $request->part_paid;
        $status['overdue'] = $request->overdue;
        $status['overdue_part_paid'] = $request->overdue_part_paid;
        $status['full_paid'] = $request->full_paid;
        
        
    
        $user_mobile = $request->user_number;
        
        $full_paid = [];
        $open = [];
        $part_paid = [];
        $overdue = [];
        $overdue_part_paid = [];
        $invoice = Invoice::where('user_number',$user_mobile)->orderBy('created_at','desc')->get();
        
        $a = [];
        for($i = 0; $i < count($invoice); $i++){
            $invoice_id = $invoice[$i]->invoice_id;
            $invoice_due_date = $invoice[$i]->invoice_due_date;
            $total_payable = $invoice[$i]->total_payable;
            
            $due_date = explode(",",$invoice[$i]->invoice_due_date);
            $due_date_arr = $due_date[0]." ".$due_date[1];
        
            $invoice_due_date = strtotime($due_date_arr);
            $today = strtotime(date('y-m-d'));
         
          
            $total_pay = InvoicePayment::where('invoice_id',$invoice_id)->sum('paymentAmount');
            /*
            $payment = InvoicePayment::where('invoice_id',$invoice_id)->get(['paymentAmount']);
            $total_pay = 0;
            
            
            if(count($payment) < 1){
                 $total_pay = 0;
            }else{
                for($j = 0;$j < count($payment); $j++){
                    $total_pay += $payment[$j]->paymentAmount;
                }
            }
            */
           
         
            
            if($total_payable == number_format((float)$total_pay, 2, '.', '') ){
                 $full_paid[] = [
                    "id" => $invoice[$i]->id,
                    "invoice_id" =>  $invoice_id,
                    "user_number" => $invoice[$i]->user_number,
                    "contact_id" => $invoice[$i]->user_number,
                    "contact_name" => $invoice[$i]->contact_name,
                    "contact_address" => $invoice[$i]->contact_address,
                    "contact_number" => $invoice[$i]->contact_number,
                    "delivery_status" => $invoice[$i]->delivery_status,
                    "invoice_date" => $invoice[$i]->invoice_date,
                    "invoice_due_date" => $invoice[$i]->invoice_due_date,
                    "invoice_desc" => $invoice[$i]->invoice_desc,
                    "delivery_partner_name" => $invoice[$i]->delivery_partner_name,
                    "delivery_partner_code" => $invoice[$i]->delivery_partner_code,
                    "service_charge" => $invoice[$i]->service_charge,
                    "delivery_charge" => $invoice[$i]->delivery_charge,
                    "total_payable" => $invoice[$i]->total_payable,
                    "vat"  => $invoice[$i]->vat,
                    "created_at"  => $invoice[$i]->created_at,
                    "updated_at" => $invoice[$i]->updated_at,
                    "payment" =>$total_pay,
                    "status" => "Full Paid"
                    
                ];
            }else if($total_pay === 0 && ($invoice_due_date >= $today)){
                $open[] = [
                    "id" => $invoice[$i]->id,
                    "invoice_id" =>  $invoice_id,
                    "user_number" => $invoice[$i]->user_number,
                    "contact_id" => $invoice[$i]->user_number,
                    "contact_name" => $invoice[$i]->contact_name,
                    "contact_address" => $invoice[$i]->contact_address,
                    "contact_number" => $invoice[$i]->contact_number,
                    "delivery_status" => $invoice[$i]->delivery_status,
                    "invoice_date" => $invoice[$i]->invoice_date,
                    "invoice_due_date" => $invoice[$i]->invoice_due_date,
                    "invoice_desc" => $invoice[$i]->invoice_desc,
                    "delivery_partner_name" => $invoice[$i]->delivery_partner_name,
                    "delivery_partner_code" => $invoice[$i]->delivery_partner_code,
                    "service_charge" => $invoice[$i]->service_charge,
                    "delivery_charge" => $invoice[$i]->delivery_charge,
                    "total_payable" => $invoice[$i]->total_payable,
                    "vat"  => $invoice[$i]->vat,
                    "created_at"  => $invoice[$i]->created_at,
                    "updated_at" => $invoice[$i]->updated_at,
                    "payment" =>$total_pay,
                    "status" => "Open"
                    
                ];
            }else if($total_pay < $total_payable  && ($invoice_due_date >= $today)){
                 $part_paid[] = [
                    "id" => $invoice[$i]->id,
                    "invoice_id" =>  $invoice_id,
                    "user_number" => $invoice[$i]->user_number,
                    "contact_id" => $invoice[$i]->user_number,
                    "contact_name" => $invoice[$i]->contact_name,
                    "contact_address" => $invoice[$i]->contact_address,
                    "contact_number" => $invoice[$i]->contact_number,
                    "delivery_status" => $invoice[$i]->delivery_status,
                    "invoice_date" => $invoice[$i]->invoice_date,
                    "invoice_due_date" => $invoice[$i]->invoice_due_date,
                    "invoice_desc" => $invoice[$i]->invoice_desc,
                    "delivery_partner_name" => $invoice[$i]->delivery_partner_name,
                    "delivery_partner_code" => $invoice[$i]->delivery_partner_code,
                    "service_charge" => $invoice[$i]->service_charge,
                    "delivery_charge" => $invoice[$i]->delivery_charge,
                    "total_payable" => $invoice[$i]->total_payable,
                    "vat"  => $invoice[$i]->vat,
                    "created_at"  => $invoice[$i]->created_at,
                    "updated_at" => $invoice[$i]->updated_at,
                    "payment" =>$total_pay,
                    "status" => "Part Paid"
                    
                ];
            }else if($total_pay === 0 && ($invoice_due_date <= $today)){
                $overdue[] = [
                    "id" => $invoice[$i]->id,
                    "invoice_id" =>  $invoice_id,
                    "user_number" => $invoice[$i]->user_number,
                    "contact_id" => $invoice[$i]->user_number,
                    "contact_name" => $invoice[$i]->contact_name,
                    "contact_address" => $invoice[$i]->contact_address,
                    "contact_number" => $invoice[$i]->contact_number,
                    "delivery_status" => $invoice[$i]->delivery_status,
                    "invoice_date" => $invoice[$i]->invoice_date,
                    "invoice_due_date" => $invoice[$i]->invoice_due_date,
                    "invoice_desc" => $invoice[$i]->invoice_desc,
                    "delivery_partner_name" => $invoice[$i]->delivery_partner_name,
                    "delivery_partner_code" => $invoice[$i]->delivery_partner_code,
                    "service_charge" => $invoice[$i]->service_charge,
                    "delivery_charge" => $invoice[$i]->delivery_charge,
                    "total_payable" => $invoice[$i]->total_payable,
                    "vat"  => $invoice[$i]->vat,
                    "created_at"  => $invoice[$i]->created_at,
                    "updated_at" => $invoice[$i]->updated_at,
                    "payment" =>$total_pay,
                    "status" => "Overdue"
                ];
            }else if($total_pay < $total_payable  && ($invoice_due_date <= $today)){
                $overdue_part_paid[] = [
                    "id" => $invoice[$i]->id,
                    "invoice_id" =>  $invoice_id,
                    "user_number" => $invoice[$i]->user_number,
                    "contact_id" => $invoice[$i]->user_number,
                    "contact_name" => $invoice[$i]->contact_name,
                    "contact_address" => $invoice[$i]->contact_address,
                    "contact_number" => $invoice[$i]->contact_number,
                    "delivery_status" => $invoice[$i]->delivery_status,
                    "invoice_date" => $invoice[$i]->invoice_date,
                    "invoice_due_date" => $invoice[$i]->invoice_due_date,
                    "invoice_desc" => $invoice[$i]->invoice_desc,
                    "delivery_partner_name" => $invoice[$i]->delivery_partner_name,
                    "delivery_partner_code" => $invoice[$i]->delivery_partner_code,
                    "service_charge" => $invoice[$i]->service_charge,
                    "delivery_charge" => $invoice[$i]->delivery_charge,
                    "total_payable" => $invoice[$i]->total_payable,
                    "vat"  => $invoice[$i]->vat,
                    "created_at"  => $invoice[$i]->created_at,
                    "updated_at" => $invoice[$i]->updated_at,
                    "payment" =>$total_pay,
                    "status" => "Overdue Part Paid"
                ];
            }

        }

        
        $filtered = [];
        $emp = [];
        $i = 0;
         foreach($status as $key=>$value){
            if($value != ""){
                array_push($filtered, $value);
            }else{
                array_push($filtered, 'emp');
            }
         }
        return array_merge(${$filtered[0]} , ${$filtered[1]} , ${$filtered[2]} , ${$filtered[3]} , ${$filtered[4]});
      
    }
    
    
    
     function ExportInvoice(Request $request){
        $user_number = $request->userNumber;
        $invoiceList =  Invoice::where('user_number',$user_number)->get();
        
        $list = [];
        foreach($invoiceList as $i){
            $invID = $i->invoice_id;
            $totalPayment = InvoicePayment::where('invoice_id', $invID)->sum('paymentAmount');
            $lastPayment = InvoicePayment::where('invoice_id', $invID)->orderBy('paymentDate','desc')->first('PaymentDate');
            $totalProductPrice = InvoiceProduct::where('invoice_id', $invID)->sum('totalSellprice');
            $total_discount = InvoiceProduct::where('invoice_id', $invID)->sum('discount');
            $address = explode("^",$i->contact_address);
            $list [] = [
                    'invoice_id' => $i->invoice_id,
                    'user_number' => $i->user_number,
                    'contact_name' => $i->contact_name,
                    'contact_address' => $address[0].",".$address[1].",".$address[2],
                    'contact_number' => $i->contact_number,
                    'delivery_status' => $i->delivery_status,
                    'invoice_date' => $i->invoice_date,
                    'invoice_due_date' => $i->invoice_due_date,
                    'invoice_desc' => $i->invoice_desc,
                    'delivery_partner_name' => $i->delivery_partner_name,
                    'delivery_partner_code' => $i->delivery_partner_code,
                    'total_product_price' => $totalProductPrice + $total_discount,
                    'total_discount' => $total_discount,
                    'last_payment' => $lastPayment,
                    'service_charge' => $i->service_charge,
                    'delivery_charge' => $i->delivery_charge,
                    'vat' => $i->vat,
                    'total_payable' => $i->total_payable,
                    'total_pay' => $totalPayment,
                    'total_due' => ($i->total_payable - $totalPayment),
                    'created_at' => $i->created_at
                ];
            
            
            
        }
        //return $list;
        //return $invoiceList;
        return view('ExportInvoice',['invoiceList' => $list]);
    }
    
    
    
       
    public function convertDate($date){
         $get_date = explode(",",$date);
         $get_date_arr = $get_date[0]." ".$get_date[1];
    
         return $convert_date = strtotime($get_date_arr);
    }
    
    
}
