<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business_registration')->nullable();
            $table->string('tax_code')->nullable();
            $table->integer('annual_revenue')->nullable();
            $table->integer('average_consumption')->nullable();
            $table->integer('workers_no_qual')->nullable();
            $table->integer('workers_deg')->nullable();
            $table->integer('female_workers')->nullable();
            $table->integer('male_workers')->nullable();
            $table->enum('type', ['processing', 'manufacture'])->default("processing");
            $table->float("longitude")->nullable();
            $table->float("latitude")->nullable();
            $table->unsignedBigInteger('business_type_id');
            $table->foreign('business_type_id')->references('id')->on('business_types')->onDelete('cascade');
            $table->string('commune_code');
            $table->foreign('commune_code')->references('code')->on('communes')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('people');
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
        Schema::dropIfExists('businesses');
    }
}
