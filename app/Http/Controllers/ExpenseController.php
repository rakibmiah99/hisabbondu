<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{

    /**
     * expenseAdd
     *
     * @param  mixed $request
     * @return response
     */
    public function expenseAdd(Request $request)
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
        $id ? $expense = Expense::find($id) : $expense = new Expense();
        $check = $this->Validated($request);
        if ($check != 1) {
            return [
                'message' => $check
            ];
        };

        
        $expense->user_number = $request->user_number;
        $expense->date = $request->date;
        $expense->date_calc =date('Y-m-d', $this->convertDate($request->date));
        $expense->amount = $request->amount;
        $expense->comment = $request->comment;
        $expense->save();
        return ['message' => $id ? 'Expense updated successfully' : 'Expense added successfully'];
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
        if (empty($request->user_number) || empty($request->amount) || empty($request->date)) {
            if (empty($request->user_number)) {
                $message[] = 'User number is required';
            }

            if (empty($request->amount)) {
                $message[] = 'Amount is required';
            }

            if (empty($request->date)) {
                $message[] = 'Date is required';
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
    public function expenseList(Request $request)
    {
        if (empty($request->user_number)) {
            return response()->json(['message' => 'Give user number please.']);
        }
        $number = $request->user_number;
        $list = Expense::where('user_number', $number)->orderBy('date_calc','desc')->get();
        return response()->json($list);
    }


    /**
     * expenseDelete
     *
     * @param  mixed $request
     * @return void
     */
    public function expenseDelete(Request $request)
    {
        $id = $request->id;
        $deleteId = Expense::find($id);
        $deleteId->delete();
        return response()->json(['message' => 'Data deleted successfully.']);
    }


    /**
     * expenseEdit
     *
     * @param  mixed $request
     * @return void
     */
    public function expenseEdit(Request $request)
    {
        $id = $request->id;
        $editId = Expense::find($id);
        return response()->json($editId);
    }


    /**
     * expenseUpdate
     *
     * @param  mixed $request
     * @return void
     */
    public function expenseUpdate(Request $request)
    {
        $id = $request->id;
        $message = $this->store($request, $id);
        return response()->json($message);
    }


    public function expenseDateFilter(Request $request)
    {
        $user_number = $request->user_number;
        $from = $this->convertDate($request->dateFrom);
        $from = date('Y-m-d', $from);
        $to =   $this->convertDate($request->dateTo);
        $to = date('Y-m-d', $to);
        $DateFilterList = Expense::where('user_number',$user_number)->whereDate('date_calc', '>=', $from)
            ->whereDate('date_calc', '<=', $to)
            ->orderBy('date_calc','desc')->get();
        return response()->json($DateFilterList);
    }
    
    
    public function convertDate($date){
         $get_date = explode(",",$date);
         $get_date_arr = $get_date[0]." ".$get_date[1];
    
         return $convert_date = strtotime($get_date_arr);
    }
    
    
    
    
    public function expenseListById(Request $request)
    {
        return Expense::where('id','=',$request->expenseId)->where('user_number',$request->user_number)->get()[0];
    }
    
     function ExportExpense(Request $request){
        $user_number = $request->userNumber;
        $expenseList =  Expense::where('user_number',$user_number)->get();
        return view('ExpenseList',['expenseList' => $expenseList]);
    }
    
    
    
}
