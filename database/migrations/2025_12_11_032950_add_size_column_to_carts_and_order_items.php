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
    Schema::table('carts', function (Blueprint $table) {
        $table->string('size')->after('qty')->default('All Size');
    });
    Schema::table('order_items', function (Blueprint $table) {
        $table->string('size')->after('qty')->default('All Size');
    });
}

public function down()
{
    Schema::table('carts', function (Blueprint $table) {
        $table->dropColumn('size');
    });
    Schema::table('order_items', function (Blueprint $table) {
        $table->dropColumn('size');
    });
}
};
