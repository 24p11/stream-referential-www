<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConceptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concept', function (Blueprint $table) {
            $table->id();
            $table->string('vocabulary_id', 15)->index();
            $table->string('concept_code', 15)->index();
            $table->string('concept_name');
            $table->string('standard_concept')->index();
            $table->string('concept_name_hash', 32)->virtualAs('MD5(concept_name)');
            $table->boolean('score')->index();
            $table->date('start_date')->index();
            $table->date('end_date')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->unique(['vocabulary_id', 'concept_code', 'concept_name_hash']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concept');
    }
}
