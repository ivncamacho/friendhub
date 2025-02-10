<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('exercise', function (Blueprint $table) {
            $table->foreignId('user_id')->default(1)->constrained('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('exercise', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }

};
