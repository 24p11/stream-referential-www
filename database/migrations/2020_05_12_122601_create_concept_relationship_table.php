<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConceptRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concept_relationship', function (Blueprint $table) {
            $table->id();
            $table->string('concept_id')->index();
            $table->string('concept_relation_id')->index();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->index();

            $table->unique(['concept_id', 'concept_relation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concept_relationship');
    }
}
