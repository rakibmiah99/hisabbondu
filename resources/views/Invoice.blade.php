<html lang="en">
<head>
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"> 
    <link href="{{asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{asset('css/responsive.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{asset('css/fontawesome.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{asset('css/animate.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{asset('css/datatables.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{asset('css/toastr.min.css') }}" rel="stylesheet" type="text/css" >
    <!--<link href="{{asset('css/style.css') }}" rel="stylesheet" type="text/css" > -->

    <script type="text/javascript" src="{{asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.bundle.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/axios.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/config.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/datatables.min.js') }}"></script>
    <style>
        *{
            line-height: 1.3;
        
        }
        body{
            /*font-family: 'Cinzel', serif;*/
            font-size: 14px;
        }
        .rtl{
             direction: rtl;
        }
        
        .table td{
            font-size: 14px!important;
        }
        
        .link:hover{
            background: black!important;
            transition: background .3s;
        }
        
        .bg-success{
            background: #42B682!important;
        }
        
        
    </style>
</head>
<body class="pt-4 pb-4">
    
 
    <?php 
        $image = "data:image/png;base64,".$user->company_logo;
    ?>
    
    <div id="invoice" class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header">
                <h4>{{$user->business_name}}</h4>
                <div>{{$user->address}}</div>
                <div>{{$user->business_phone}}</div>
                <div><?php if($user->email != null){ echo $user->email;}?></div>
                <div class="mb-2"><?php if($user->website !== null) { echo $user->website;}else{echo "";}?></div>
             </div>
             <div class="logo d-flex align-items-center justify-content-end">
                <img style="margin-right: 15px;"  src="<?php echo $image;?>" style="border-radius: 50%";>
            
            </div>
        </div>
        
        <div class="bg-success invoice-text d-flex justify-content-end" style="padding-right: 40px">
            <h3 class="m-0 bg-white text-uppercase" style="padding: 10px 70px; display: inline-block;">Invoice</h3>
        </div>
        
        <div class="invoice-info d-flex justify-content-between">
            <div class="customer-info p-3">
                <h4 class="text-uppercase">Invoice To</h4>
                <div>{{$info->contact_name}}</div>
                <div>{{$info->contact_number}}</div>
                <div>
                    <?php
                     
                        $explodeStr = explode("^",$info->contact_address);
                        echo $explodeStr[0]."<br>".$explodeStr[1]."<br>".$explodeStr[2]
                    ?>
                </div>
            </div>
            <div class="customer-info p-3" style="margin-right: 55px;">
                <div><b>INVOICE#: </b>{{$info->invoice_id}}</div>
                <div class="mt-2">{{$info->invoice_date}}</div>
            </div>
        </div>
        <div class="p-3">
            <p>{{$info->invoice_desc}}</p>
            <table class="table  table-sm table-borderless table-light mt-3">
                <thead>
                    <tr class="border-bottom border-top">
                        <th class="text-center">SL#</th>
                        <th>Product Name</th>
                        <th class="text-end">Quantity</th>
                        <th class="text-center">Unit</th>
                        <th class="text-end">Price</th>
                        <th class="text-end" style="padding-right: 15px;">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $ii = 1; $subTotal = 0; $discount = 0; $totalPayment = 0; $due = 0;?>
            
                    @foreach($product_array as $p)
                    <tr class="border-bottom">
                        <td class="text-center">{{$ii++}}</td>
                        <td>{{$p->productName}}</td>
                        <td class="text-end">{{$p->productQuantity}}</td>
                        <td class="text-center">{{$p->productUnit}}</td>
                        <td class="text-end"><?php echo number_format((float)$p->sellPrice, 2, '.', '');?></td>
                        <td class="text-end" style="padding-right: 15px;"><?php echo number_format((float)($p->totalSellprice + $p->discount), 2, '.', '');?></td>
                        <?php $subTotal +=  $p->totalSellprice;?>
                        <?php $discount +=  $p->discount?>
                    </tr>
                   @endforeach
                   
                   @foreach($payment_array as $p)
                       <?php $totalPayment += $p->paymentAmount; ?>
                   @endforeach
                        
                   <?php  $due = $info->total_payable - $totalPayment?>
                </tbody>
                <tfoot>
                    
                
                    
                    
                    <tr>
                        <td colspan="5" class="text-end">Sub Total</td>
                        <td class="text-end border-bottom" style="padding-right: 15px;"><?php echo number_format((float)($subTotal+$discount), 2, '.', '');?></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end ">(-) Discount</td>
                        <td class="text-end border-bottom border-success " style="padding-right: 15px;"><?php echo number_format((float)$discount, 2, '.', '');?></td>
                    </tr>=
                    <tr>
                        <td colspan="5" class="text-end "><b>Sub Total Less Discount</b></td>
                        <td class="text-end  " style="padding-right: 15px;"><b><?php echo number_format((float)($subTotal), 2, '.', '');?></b></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end">Service Charge</td>
                        <?php $serviceCharge = ($subTotal * $info->service_charge)/100; ?>
                        <td class="text-end border-bottom" style="padding-right: 15px;"><?php echo number_format((float)(($subTotal * $info->service_charge)/100), 2, '.', '');?></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end">Vat</td>
                        <td class="text-end border-bottom" style="padding-right: 15px;"><?php echo number_format((float)(($subTotal+$serviceCharge) * $info->vat)/100, 2, '.', '');?></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end">Delivery Charge</td>
                        <td class="text-end border-bottom  border-success" style="padding-right: 15px;"><?php echo number_format((float)$info->delivery_charge, 2, '.', '');?></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end"><b>Invoice Total</b></td>
                        <td class="text-end border-bottom" style="padding-right: 15px;"><b><?php echo number_format((float)$info->total_payable, 2, '.', '');?></b></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end ">(-) Paid</td>
                        <td class="text-end border-bottom border-success" style="padding-right: 15px;"><?php echo number_format((float)$totalPayment, 2, '.', '');?></td>
                    </tr>
                    
                    <tr class="">
                        <td colspan="5" class="text-end"><b>Balance Due</b></td>
                        <td class="text-end border-bottom" style="padding-right: 15px;"><b><?php echo number_format((float)$due, 2, '.', '');?></b></td>
                    </tr>
                </tfoot>
            </table>
                <p class=""><b>
                    <?php 
                        if($due > 0){
                            echo "Requesting you to please pay the due amount urgently." ;     
                        }else{
                            echo "";
                        }
                    ?>
                    </b>
                </p>
        </div>
    </div>
    
      
      <div class="container text-center">
          <a href="#" id="print" style="padding: 10px 25px;border-radius: 100px;background: #0985D9;color: white;" class="link">Print</a>
      </div>
    
</body>
</html>




<script>
    $(document).ready(function (){
        window.print();
    })
    
    $('#print').click(function(){
            window.print();
       })
</script>

