<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('attendances', function (Blueprint $table) {
        $table->date('date')->nullable();  
    });
}

    public function down()
{
    Schema::table('attendances', function (Blueprint $table) {
        $table->dropColumn('date');  
    });
}
}
