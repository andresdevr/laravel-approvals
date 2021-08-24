<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('approvals.table_name'), function (Blueprint $table) {
            $table->id();
	    $table->string('pendingable_type');
	    $table->string('pendingable_id');
	    $table->string('attribute');
	    $table->text('value');
	    $table->text('reason_for_denial')->nullable();
	    $table->string('user_id')->nullable();
	    $table->string('status');
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
        Schema::dropIfExists('posts');
    }
}
