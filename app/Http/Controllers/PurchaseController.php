<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\ContactModel;
use App\Models\Invoice;
use App\Models\InvoicePayment;

class PurchaseController extends Controller
{
    /**
     * expenseAdd
     *
     * @param  mixed $request
     * @return response
     */
    public function purchaseAdd(Request $request)
    {
        $message = $this->store($request);
        return response()->json($message);
    }


    /**
     * store
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function store(Request $request, $id = null)
    {
        $id ? $purchase = Purchase::find($id) : $purchase = new Purchase();
        $check = $this->Validated($request);
        if ($check != 1) {
            return [
                'message' => $check
            ];
        };

        $purchase->user_number = $request->user_number;
        $purchase->total_purchase = $request->total_purchase;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->purchase_date_calc = date('Y-m-d', $this->convertDate($request->purchase_date));
        $purchase->total_pay = $request->total_pay;
        $purchase->pay_date = $request->pay_date;
        $purchase->comment = $request->comment;
        $purchase->due = $request->due;
        $purchase->supplier_id = $request->supplier_id;
        $purchase->save();
        return ['message' => $id ? 'Purchase updated successfully' : 'Purchase added successfully'];
    }


    /**
     * Validated
     *
     * @param  mixed $request
     * @return void
     */
    public function Validated(Request $request)
    {
        $message = [];
        if (empty($request->user_number) || empty($request->total_purchase) || empty($request->purchase_date) || empty($request->total_pay) || empty($request->pay_date) || empty($request->due) || empty($request->supplier_id)) {

            if (empty($request->user_number)) {
                $message[] = 'User number is required';
            }

            if (empty($request->total_purchase)) {
                $message[] = 'Total purchase amount is required';
            }

            if (empty($request->purchase_date)) {
                $message[] = 'Purchase date is required';
            }

            if (empty($request->total_pay)) {
                $message[] = 'Total pay is required';
            }

            if (empty($request->pay_date)) {
                $message[] = 'Pay date is required';
            }

            if (empty($request->due)) {
                $message[] = 'Due is required';
            }

            if (empty($request->supplier_id)) {
                $message[] = 'Supplier id is required';
            }
            return $message;
        } else {
            return 1;
        }
    }


    /**
     * expenseList
     *
     * @param  mixed $request
     * @return void
     */
    public function purchaseList(Request $request)
    {
        if (empty($request->user_number)) {
            return response()->json(['message' => 'Give user number please.']);
        }
        $number = $request->user_number;
        $list = Purchase::where('user_number', $number)->get();
        return response()->json($list);
    }


    /**
     * expenseDelete
     *
     * @param  mixed $request
     * @return void
     */
    public function purchaseDelete(Request $request)
    {
        $id = $request->id;
        $deleteId = Purchase::find($id);
        $deleteId->delete();
        return response()->json(['message' => 'Data deleted successfully.']);
    }


    /**
     * expenseEdit
     *
     * @param  mixed $request
     * @return void
     */
    public function purchaseEdit(Request $request)
    {
        $id = $request->id;
        $editId = Purchase::find($id);
        return response()->json($editId);
    }


    /**
     * expenseUpdate
     *
     * @param  mixed $request
     * @return void
     */
    public function purchaseUpdate(Request $request)
    {
        $id = $request->id;
        $message = $this->store($request, $id);
        return response()->json($message);
    }

    public function supplierList(Request $request)
    {
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
            
            $havePurchase = Purchase::where('supplier_id', $item->id)->get();
            if(count($havePurchase) > 0){
            
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
        }
        return $list;
        
        
    }

    public function getPurchaseList($key, $value,  $user_number, $condition = '=')
    {
        $data = Purchase::join('contact', 'purchases.supplier_id', 'contact.id')->where($key, $condition, $value)->where('user_number', $user_number)->where('contact.contact_type', 'Supplier')->select('purchases.*', 'contact.contact_type', 'contact.name', 'contact.mobile_no')->get();
        return $data;
    }

    public function getDateWiseList(Request $request)
    {
        $date = date('Y-m-d', strtotime($request->purchase_date));
        $data = $this->getPurchaseList('purchase_date', $date, $request->user_number);
        return response()->json($data);
    }

    public function payableList(Request $request)
    {
        $data = $this->getPurchaseList('due', 0, $request->user_number, '>');
        return response()->json($data);
    }

    public function unPayableList(Request $request)
    {
        $data = $this->getPurchaseList('due', 0, $request->user_number);
        return response()->json($data);
    }
    
     public function supplierWisePurchase(Request $request)
    {
        $data = Purchase::where('supplier_id', $request->supplier_id)->where('user_number', $request->user_number)->join('contact', 'purchases.supplier_id', 'contact.id')->select('purchases.*', 'contact.contact_type', 'contact.name', 'contact.mobile_no')->orderBy('purchase_date_calc','asc')->get();
        return response()->json($data);
    }

    public function contactWisePayable(Request $request)
    {
        $data = Purchase::where('supplier_id', $request->supplier_id)->where('user_number', $request->user_number)->where('due', '>', 0)->join('contact', 'purchases.supplier_id', 'contact.id')->select('purchases.*', 'contact.contact_type', 'contact.name', 'contact.mobile_no')->get();
        return response()->json($data);
    }
    public function individualUserExport(Request $request)
    {
        
         $purchase = Purchase::where('user_number', $request->user_mobile)->get();
         $items = [];
         foreach($purchase as $p){
             $supplier = ContactModel::where('id',$p->supplier_id)->first();
             
             $items [] = [
                    'id' => $p->id,
                    'name' => $supplier->name,
                    'mobile' => $supplier->mobile_no,
                    'date' => $p->purchase_date,
                    'total_purchase' => $p->total_purchase,
                    'total_pay' => $p->total_pay
                 ];
         }
         
         
         return view('IndividualSupplierList',['purchaseList' => $items]);
        
    }

    public function supplierWiseExport()
    {
        $AllSupplierList = ContactModel::select('contact.*', 'purchases.*')->where('contact_type', 'Supplier')->where('user_mobile',$request->user_mobile)->where('supplier_id',$request->suplier_id)->join('purchases','purchases.supplier_id','contact.id' )->get();
        return view('AllSupplierList',['AllSupplierList' => $AllSupplierList]);
    }
    
     public function convertDate($date){
         $get_date = explode(",",$date);
         $get_date_arr = $get_date[0]." ".$get_date[1];
    
         return $convert_date = strtotime($get_date_arr);
    }
}
