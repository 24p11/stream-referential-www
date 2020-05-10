<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->string('concept_id', 15 * 2)->index();
            $table->json('content');
            $table->string('name', 30)->virtualAs(self::jsonContent('name'))->index();
            $table->string('value', 500)->virtualAs(self::jsonContent('value'))->index();
            $table->boolean('standard_concept')->default(false)->index();
            $table->enum('metadata_type', ['DEFAULT', 'LIST'])->default('DEFAULT');
            $table->date('start_date')->index();
            $table->date('end_date')->index()->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->index();

            $table->unique(['concept_id', 'name']);
        });
    }

    private static function jsonContent($column)
    {
        return "json_unquote(json_extract(`content`,'$.$column'))";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata');
    }
}
