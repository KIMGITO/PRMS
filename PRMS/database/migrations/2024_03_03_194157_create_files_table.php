<?php

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('case_number')->unique();
            $table->foreignId('casetype_id')->constrained('casetypes')->onDelete('cascade');
            $table->date('filing_date');
            $table->date('ruling_date')->nullable();
            $table->text('plaintiffs');
            $table->text('defendants');
            $table->foreignId('judge_id')->constrained('judges')->onDelete('cascade');
            $table->foreignId('court_id')->constrained('courts')->onDelete('cascade');
            $table->text('case_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
