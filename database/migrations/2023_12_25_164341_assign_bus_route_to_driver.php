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
        Schema::create('assign_bus_route_to_driver', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('route_id')->nullable();;
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('bus_id')->references('id')->on('bus_list')->onDelete('cascade');
            $table->foreign('route_id')->references('id')->on('route_list')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('driver_info')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            // Create an index on the columns.
            $table->index(['bus_id', 'route_id', 'driver_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus', function (Blueprint $table) {
            //
        });
    }
};
