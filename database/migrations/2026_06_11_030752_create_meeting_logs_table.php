<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('meeting_logs', function (Blueprint $table) {
    $table->id();
    $table->string('week')->nullable();
    $table->dateTime('meeting_time')->nullable();
    $table->string('customer_id')->nullable();
    $table->string('project_id')->nullable();
    $table->string('team')->nullable();
    $table->text('leader_names')->nullable();
    $table->string('duration')->nullable();
    $table->string('video_link')->nullable();
    $table->longText('summary')->nullable();
    $table->string('link_summary')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_logs');
    }
};
