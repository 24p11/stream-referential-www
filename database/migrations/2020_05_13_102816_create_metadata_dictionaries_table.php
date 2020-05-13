<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMetadataDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('vocabulary_id', 15)->index();
            $table->string('metadata_name')->index();
            $table->text('description')->nullable();
            $table->string('type')->nullable()->index();
            $table->date('start_date')->index();
            $table->date('end_date')->index()->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->index();

            $table->unique(['vocabulary_id', 'metadata_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata_dictionaries');
    }
}
