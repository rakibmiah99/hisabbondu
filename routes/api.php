<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserRegistrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// ** Home counting 
Route::post('/HomeCounting', [HomeController::class, 'HomeCounting']);

// *** User Registration Password Reset & Login
Route::post('/CreateOTP', [UserRegistrationController::class, 'CreateOTP']);
Route::post('/OtpVerification', [UserRegistrationController::class, 'OtpVerification']);
Route::post('/UserRegistration', [UserRegistrationController::class, 'UserRegistration']);
Route::post('/UserLogin', [UserRegistrationController::class, 'UserLogin']);
Route::post('/CheckUser', [UserRegistrationController::class, 'CheckUser']);
Route::post('/UpdatePassword', [UserRegistrationController::class, 'UpdatePassword']);
Route::post('/update-profile', [UserRegistrationController::class, 'updateProfile']);


//*** product
Route::post('/ProductFilter', [ProductController::class, 'ProductFilter']);
Route::post('/ProductUnitByType', [ProductController::class, 'ProductUnitByType']);
Route::get('/ProductType', [ProductController::class, 'ProductType']);
Route::get('/ProductUnit', [ProductController::class, 'ProductUnit']);
Route::post('/ProductAdd', [ProductController::class, 'ProductAdd']);
Route::post('/ProductList', [ProductController::class, 'ProductList']);
Route::post('/ProductDetails', [ProductController::class, 'ProductDetails']);
Route::post('/ProductUpdate', [ProductController::class, 'ProductUpdate']);
Route::post('/ProductDelete', [ProductController::class, 'ProductDelete']);
Route::get('/ExportProductList/{user_number}',[ProductController::class,'ExportProductList']);


//***Expense
Route::post('/expenseAdd', [ExpenseController::class, 'expenseAdd']);
Route::post('/expenseList', [ExpenseController::class, 'expenseList']);
Route::post('/expenseDelete', [ExpenseController::class, 'expenseDelete']);
Route::post('/expenseEdit', [ExpenseController::class, 'expenseEdit']);
Route::post('/expenseUpdate', [ExpenseController::class, 'expenseUpdate']);
Route::post('/expenseDateFilter', [ExpenseController::class, 'expenseDateFilter']);
Route::post('/expenseListById',[ExpenseController::class, 'expenseListById']);
Route::get('/ExportExpense/{userNumber}', [ExpenseController::class, 'ExportExpense']);


Route::get('/individualUserExport/{user_mobile}', [PurchaseController::class, 'individualUserExport']);
Route::get('/supplierWisePurchaseExport/{user_mobile}/{suplier_id}', [PurchaseController::class, 'supplierWiseExport']);


//**Purchase
Route::post('/purchaseAdd', [PurchaseController::class, 'purchaseAdd']);
Route::post('/purchaseList', [PurchaseController::class, 'purchaseList']);
Route::post('/purchaseDelete', [PurchaseController::class, 'purchaseDelete']);
Route::post('/purchaseEdit', [PurchaseController::class, 'purchaseEdit']);
Route::post('/purchaseUpdate', [PurchaseController::class, 'purchaseUpdate']);
Route::post('/supplier-list', [PurchaseController::class, 'supplierList']);


//**Invoice
Route::post('/invoiceAdd', [InvoiceController::class, 'storeInvoice']);
Route::post('/get-invoice', [InvoiceController::class, 'getInvoice']);
Route::get('/getInvoicePrint/{invoice_id}', [InvoiceController::class, 'getInvoicePrint']);
Route::post('/update-invoice', [InvoiceController::class, 'updateInvoice']);
Route::post('/get-invoice-list', [InvoiceController::class, 'getInvoiceList']);
Route::post('/invoice-delete', [InvoiceController::class, 'deleteInvoice']);
Route::post('/update', [InvoiceController::class, 'update']);
Route::post('/filter', [InvoiceController::class, 'filter']);
Route::post('/filterWithPay',[InvoiceController::class, 'filterWithPay']);
Route::get('/invoice-export/{userNumber}', [InvoiceController::class, 'ExportInvoice']);



//**contact
Route::post('/ContactFilter', [ContactController::class, 'ContactFilter']);
Route::post('/ContactAdd', [ContactController::class, 'ContactAdd']);
Route::post('/ContactList', [ContactController::class, 'ContactList']);
Route::post('/ContactDetails', [ContactController::class, 'ContactDetails']);
Route::post('/ContactUpdate', [ContactController::class, 'ContactUpdate']);
Route::post('/ContactDelete', [ContactController::class, 'ContactDelete']);
Route::get('/ExportContact/{userNumber}', [ContactController::class, 'ExportContact']);


//**Settings
//Route::post('/update-profile', [ContactController::class, 'UpdateProfile']);
Route::post('/getUser', [ContactController::class, 'getUser']);
Route::post('/change-password', [ContactController::class, 'changePassword']);
Route::post('/getDefaultValue', [UserRegistrationController::class,'getDefaultValue']);
Route::post('/updateDefaultValue', [UserRegistrationController::class,'updateDefaultValue']);





// Route::post('/purchaseDateFilter', [ExpenseController::class, 'purchaseDateFilter']);
Route::post('/payable-list', [PurchaseController::class, 'payableList']);
Route::post('/unpayable-list', [PurchaseController::class, 'unPayableList']);
Route::post('/date-wise-list', [PurchaseController::class, 'getDateWiseList']);
Route::post('/contact-wise-payable-list', [PurchaseController::class, 'contactWisePayable']);

Route::post('/supplierWisePurchase', [PurchaseController::class, 'supplierWisePurchase']);


//Term AND Condition
Route::get('/Terms-and-condition', function(){
    return "This is Terms And Condition Page";
});



Route::get('invoce', function(){
    return view('Invoice');
});
