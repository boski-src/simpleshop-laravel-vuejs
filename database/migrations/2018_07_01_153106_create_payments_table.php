<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->increments('id');

                $table->string('first_name', 64)->nullable();
                $table->string('last_name', 64)->nullable();

                $table->string('payer_email', 127)->nullable();
                $table->string('payer_id', 13)->nullable();
                $table->string('payer_status', 20)->nullable();

                $table->string('payment_date', 32)->nullable();
                $table->string('payment_status', 20)->nullable();
                $table->string('payment_type', 10)->nullable();
                $table->string('payment_fee', 9, 2)->nullable();
                $table->string('payment_gross', 9, 2)->nullable();

                $table->string('address_city', 40)->nullable();
                $table->string('address_country', 64)->nullable();
                $table->string('address_country_code', 2)->nullable();
                $table->string('address_name', 128)->nullable();
                $table->string('address_state', 40)->nullable();
                $table->string('address_status', 20)->nullable();
                $table->string('address_street', 200)->nullable();
                $table->string('address_zip', 20)->nullable();

                $table->string('txn_id', 19)->nullable();
                $table->string('txn_type', 20)->nullable();

                $table->double('test_ipn')->nullable();
                $table->string('verify_sign', 127)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
