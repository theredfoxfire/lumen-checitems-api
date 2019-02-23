<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('updated_by')->unsigned();
            $table->text('description')->nullable(); // string 0 - 500 char
            $table->integer('urgency')->unsigned()->default(0);  // integer 0 - 2 char
            $table->time('due')->nullable()->default(null); // Time
            $table->time('completed_at')->nullable()->default(null); // Time
            $table->boolean('is_completed')->default(0);
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
        Schema::dropIfExists('items');
    }
}
