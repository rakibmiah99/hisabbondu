<?php

namespace App\Http\Controllers;
use App\Models\ProductModel;
use App\Models\ProductTypeUnit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
   function ProductType(){
        $result= ProductTypeUnit::orderBy('type','asc')->get(['type','unit']);
        return $result;
    }
    
    function ProductUnit(){
        $result= ProductTypeUnit::orderBy('unit','asc')->get(['type','unit']);
        return $result;   
    }    
    
   function ProductUnitByType(Request $request){
        $type=$request->input('type');
        $result= ProductTypeUnit::where('type',$type)->get(['unit']);
        return $result;
    }
    
    
    function ProductAdd(Request $request){
        date_default_timezone_set("Asia/Dhaka");
        $user_mobile=$request->input('user_mobile');
        $p_code=$request->input('p_code');
        $p_name=$request->input('p_name');
        $p_unit=$request->input('p_unit');
        $p_type=$request->input('p_type');
        $p_desc=$request->input('p_desc');
        $sell_price=$request->input('sell_price');
        $purchase_price=$request->input('purchase_price');
        $discount_type=$request->input('discount_type');
        $discount_percentage=$request->input('discount_percentage');
        $discount_flat=$request->input('discount_flat');
        $discount_price=$request->input('discount_price');
        $profit=$request->input('profit');
        $stock=$request->input('stock');
        $created_date= date("d-m-Y");
        $created_time= date("h:i:sa");
        $created_by=$request->input('created_by');

        $result= ProductModel::insert([
            'user_mobile'=>$user_mobile,
            'p_code'=>$p_code,
            'p_name'=>$p_name,
            'p_unit'=>$p_unit,
            'p_type'=>$p_type,
            'p_desc'=>$p_desc,
            'sell_price'=>$sell_price,
            'purchase_price'=>$purchase_price,
            'discount_type'=>$discount_type,
            'discount_percentage'=>$discount_percentage,
            'discount_flat'=>$discount_flat,
            'discount_price'=>$discount_price,
            'profit'=>$profit,
            'stock'=>$stock,
            'created_date'=>$created_date,
            'created_time'=>$created_time,
            'created_by'=>$created_by
        ]);
        return $result;
    }

    function ProductList(Request $request){
        $user_mobile=$request->input('user_mobile');
        $result= ProductModel::where('user_mobile',$user_mobile)->orderBy('id','desc')->get();
        return $result;
    }

    function ProductDetails(Request $request){
        $id=$request->input('id');
        $result= ProductModel::where('id',$id)->get();
        return $result;
    }



    function ProductUpdate(Request $request){
        date_default_timezone_set("Asia/Dhaka");

        $id=$request->input('id');
        $p_code=$request->input('p_code');
        $p_name=$request->input('p_name');
        $p_unit=$request->input('p_unit');
        $p_type=$request->input('p_type');
        $p_desc=$request->input('p_desc');
        $sell_price=$request->input('sell_price');
        $purchase_price=$request->input('purchase_price');
        $discount_type=$request->input('discount_type');
        $discount_percentage=$request->input('discount_percentage');
        $discount_flat=$request->input('discount_flat');
        $discount_price=$request->input('discount_price');
        $profit=$request->input('profit');
        $stock=$request->input('stock');

        $created_date= date("d-m-Y");
        $created_time= date("h:i:sa");
        $updated_by=$request->input('updated_by');

        $result= ProductModel::where('id',$id)->update([
            'p_code'=>$p_code,
            'p_name'=>$p_name,
            'p_unit'=>$p_unit,
            'p_type'=>$p_type,
            'p_desc'=>$p_desc,
            'sell_price'=>$sell_price,
            'purchase_price'=>$purchase_price,
            'discount_type'=>$discount_type,
            'discount_percentage'=>$discount_percentage,
            'discount_flat'=>$discount_flat,
            'discount_price'=>$discount_price,
            'profit'=>$profit,
            'stock'=>$stock,
            'updated_date'=>$created_date,
            'updated_time'=>$created_time,
            'updated_by'=>$updated_by
        ]);
        return $result;
    }

    function ProductDelete(Request $request){
        $id=$request->input('id');
        $result=ProductModel::where('id','=',$id)->delete();
        if ($result==true){
            return 1;
        }
        else{
            return 0;
        }
    }


   function ProductFilter(Request $request){
        $user_mobile=$request->input('user_mobile');
        $available=$request->input('available');
        $not_available=$request->input('not_available');
        $result= ProductModel::where('user_mobile',$user_mobile)->get();
        
        if(strlen($available)==0){
             $result= ProductModel::where('user_mobile',$user_mobile)->where('stock',"NO")->get();
        }
        else{
             $result= ProductModel::where('user_mobile',$user_mobile)->where('stock',"YES")->get();
        }
        
        return $result;
    }
    
    
     function ExportProductList(Request $request){
        $user_number = $request->user_number;
        $productList =  ProductModel::where('user_mobile',$user_number)->get();
        return view('ProductList',['productList' => $productList]);
    }

}
