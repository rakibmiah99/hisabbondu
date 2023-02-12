<html>
    <head>
        <title>Expense List</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <style>
            .export-title{
                background: #42B582;
                font-size: 20px;
                color: white;
                text-align: center;
                padding: 30px;
                text-transform: uppercase;
            }
        
            #data_table_wrapper{
                display:none;
            }
            .btn{
                border-radius: 0;
            }
            .btn:hover{
                color: white;
            }
            .btn-excel{
                background: #10783F;
                color: white;
            }
            
            .btn-csv{
                background: #5B9772;
                color: white;
            }
            .btn-pdf{
                background: #C5494A;
                color: white;
            }
            
            
            
            .footer{
                background: #D3E4CD;
                padding: 15px;
                text-align: center;
                position: absolute;
                bottom: 0;
                color: black;
            }
            .footer .nav-link{
                display: inline-block;
                color: black;
                font-weight: bold;
                 padding-left: 2px;
            }
            .footer .nav-link:hover{
                color: #42B582;
                text-decoration: underline;
               
            }
            #data_table{
                display:none;
            }
            
        </style>
    </head>
    <html>
        
        <h1 class="export-title">Expense Export</h1>
        
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <button class="btn d-flex justify-content-between align-items-center w-100  btn-excel" style="padding: 12px 30px;">
                        <div><i class="fa-solid fa-file-excel" style="margin-right: 10px;"></i><span>Export To Excel </span></div>
                        
                        <i class="fa-solid fa-download"></i>
                    </button>
                </div>
                <div class="col-md-4 mt-3 d-none">
                    <button class="btn d-flex justify-content-between align-items-center w-100  btn-pdf" style="padding: 12px 30px;">
                        <div><i class="fa-solid fa-file-pdf" style="margin-right: 10px;"></i><span>Export To PDF </span></div>
                        
                        <i class="fa-solid fa-download"></i>
                    </button>
                </div>
                <div class="col-md-4 mt-3 d-none">
                    <button class="btn d-flex justify-content-between align-items-center w-100  btn-csv" style="padding: 12px 30px;">
                        <div><i class="fa-solid fa-file-csv" style="margin-right: 10px;"></i><span>Export To CSV </span></div>
                        
                        <i class="fa-solid fa-download"></i>
                    </button>
                </div>
            </div>
        </div>
         
        <div class="footer w-100">All data comes from <a href="http://hisabbondhu.com/" class="nav-link">hisabbondhu.com</a></div>
        
       <table id="data_table" class="display table-sm hover table-stipped" style="width:100%">
        <thead>
            <tr>
                <th>SL No</th>
                <th>Date</th>
                <th>Ammount</th>
                <th>Comments</th>
                <th>Created Time</th>
                <th>Updated Time</th>
            </tr>
        </thead>
        <tbody style="margin-bottom:40px;">
            <?php $i=1; ?>
            @foreach($expenseList as $list)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$list->date}}</td>
                <td>{{$list->amount}}</td>
                <td>{{$list->comment}}</td>
                <td>{{$list->created_at}}</td>
                <td>{{$list->updated_at}}</td>
            </tr>
            @endforeach
            
            
        </tbody>
      
    </table>
    <script>
    
        $(document).ready(function() {
            $('#data_table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );
            
            
            
            $('.btn-excel').on('click',function(){
                $('.buttons-excel').trigger('click');
            })
            
            $('.btn-pdf').on('click',function(){
                $('.buttons-pdf').trigger('click');
            })
            
            $('.btn-csv').on('click',function(){
                $('.buttons-csv').trigger('click');
            })
            
            
        } );
    </script>
    </html>
</html>