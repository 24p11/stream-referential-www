<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Util\KeyUtils;

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
            $table->string('vocabulary_id_concept_code', 15 * 2)->virtualAs($this->concatKey())->index();
            $table->string('concept_name');
            $table->boolean('standard_concept')->default(false)->index();
            $table->string('concept_name_hash', 32)->virtualAs('MD5(concept_name)');
            $table->boolean('score')->default(false)->index();
            $table->date('start_date')->index();
            $table->date('end_date')->index()->nullable();
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

    private function concatKey()
    {
        return sprintf("CONCAT(vocabulary_id, '%s', concept_code)", KeyUtils::SEPARATOR);
    }
}
