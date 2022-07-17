<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->float('performance_bonus')->default(0.0);
            $table->unsignedBigInteger('bonus')->default(0.0);
            $table->unsignedBigInteger('transportation_cost')->default(0.0);
            $table->unsignedBigInteger('medical_cost')->default(0.0);
            $table->float('gross_pay');
            $table->dateTime('date')->default(Carbon::now());
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
        Schema::dropIfExists('payrolls');
    }
};
