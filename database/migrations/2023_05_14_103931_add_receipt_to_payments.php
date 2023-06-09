<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('receipt')->after('payment_method');
        });
    }
    
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('receipt');
        });
    }
    
};
