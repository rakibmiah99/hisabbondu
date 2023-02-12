<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('contact_id');
            $table->string('contact_name');
            $table->text('contact_address');
            $table->string('contact_number');
            $table->string('delivery_status');
            $table->string('invoice_date');
            $table->string('invoice_desc');
            $table->string('delivery_partner_name');
            $table->string('delivery_partner_code');
            $table->double('service_charge');
            $table->double('delivery_charge');
            $table->double('total_payable');
            $table->double('vat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
