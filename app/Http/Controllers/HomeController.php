<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use App\Models\ProductModel;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\InvoicePayment;
use App\Models\Purchase;
use App\Models\Expense;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function HomeCounting(Request $request){
        $user_mobile=$request->input('user_mobile');
        $Contact= ContactModel::where('user_mobile',$user_mobile)->get()->count();
        $Product= ProductModel::where('user_mobile',$user_mobile)->get()->count();
        
        //PABO Dibo
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
            
                'pabo'=> ($purchase->dibo < 0) ? ($totalPayable - $toatalPayment) + abs($purchase->dibo)  : $totalPayable - $toatalPayment,
                'dibo'=> ($purchase->dibo > 0) ? $purchase->dibo : 0 
                ];
        }
        
        $pabo = 0;
        $dibo = 0;
        
        
       
        foreach($list as $total){
            $pabo += $total['pabo'];
            $dibo += $total['dibo'];
        }
        //End Pabo Dibo
        
        
        
        //Date last three month
        $thisMonth = date('Y-m-31', strtotime("now"));
        $day = date('Y-m-01',strtotime("now"));
        $lastMonthStart = date('Y-m-01', strtotime("last Month"));
        $lastMonthEnd = date('Y-m-31', strtotime("last Month"));
        $lastBeforeLastMonthStart = date('Y-m-01', strtotime("-2 Month"));
        $lastBeforeLastMonthEnd = date('Y-m-31', strtotime("-2 Month"));
        
        
       //Purchase lasth three month
       $thisMonthPurchase = Purchase::where('user_number', $user_mobile)->whereBetween('purchase_date_calc',[$day,$thisMonth])->sum('total_purchase');
       $latMonthPurchase = Purchase::where('user_number', $user_mobile)->whereBetween('purchase_date_calc',[$lastMonthStart,$lastMonthEnd])->sum('total_purchase');
       $latMonthBeforePurchase = Purchase::where('user_number', $user_mobile)->whereBetween('purchase_date_calc',[$lastBeforeLastMonthStart,$lastBeforeLastMonthEnd])->sum('total_purchase');
       date_default_timezone_set("Asia/Dhaka");
       $purchase  = [
           
                  [
                      "month" => date('M',strtotime("now")),
                      "amount" => $thisMonthPurchase
                  ],
                  [
                      "month" =>date('M',strtotime("last Month")),
                      "amount" => $latMonthPurchase
                  ],
                  [
                      "month" => date('M',strtotime("-2 Month")),
                      "amount" => $latMonthBeforePurchase
                  ]
           ];
           
       //Expense last three month
       $thisMonthExpense = Expense::where('user_number', $user_mobile)->whereBetween('date_calc',[$day,$thisMonth])->sum('amount');
       $lastMonthExpense = Expense::where('user_number', $user_mobile)->whereBetween('date_calc',[$lastMonthStart,$lastMonthEnd])->sum('amount');
       $lastMonthBeforeExpense = Expense::where('user_number', $user_mobile)->whereBetween('date_calc',[$lastBeforeLastMonthStart,$lastBeforeLastMonthEnd])->sum('amount');
      
       $expense  = [
           
                  [
                      "month" => date('M',strtotime("now")),
                      "amount" => $thisMonthExpense
                  ],
                  [
                      "month" =>date('M',strtotime("last Month")),
                      "amount" => $lastMonthExpense
                  ],
                  [
                      "month" => date('M',strtotime("-2 Month")),
                      "amount" => $lastMonthBeforeExpense
                  ]
           ];
           
           
        //Invoice total payable last three month
        $thisMonthPayable = Invoice::where('user_number', $user_mobile)->whereBetween('invoice_date_calc',[$day,$thisMonth])->sum('total_payable');
        $lastMonthPayable = Invoice::where('user_number', $user_mobile)->whereBetween('invoice_date_calc',[$lastMonthStart,$lastMonthEnd])->sum('total_payable');
        $lastMonthBeforePayable = Invoice::where('user_number', $user_mobile)->whereBetween('invoice_date_calc',[$lastBeforeLastMonthStart,$lastBeforeLastMonthEnd])->sum('total_payable');
      
        $totalPayable  = [
           
                  [
                      "month" => date('M',strtotime("now")),
                      "amount" => $thisMonthPayable
                  ],
                  [
                      "month" =>date('M',strtotime("last Month")),
                      "amount" => $lastMonthPayable
                  ],
                  [
                      "month" => date('M',strtotime("-2 Month")),
                      "amount" => $lastMonthBeforePayable
                  ]
           ];
           
        
        return response()->json((
            array(
                'TotalContact'=>$Contact,
                'TotalProduct'=>$Product,
                'Pabo' => $pabo,
                'Dibo' => $dibo,
                'Purchase' => $purchase,
                'Expense' => $expense,
                'Sales' => $totalPayable
                )
        ));
    }


}
