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
        Schema::create('meeting_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('meeting_id')->constrained('meeting_logs')->onDelete('cascade');
    $table->enum('type', ['action_item', 'quyet_dinh', 'van_de']); // Loại nội dung
    $table->integer('stt')->nullable();        // Số thứ tự
    $table->text('noi_dung');                  // Nội dung chính
    $table->string('deadline')->nullable();    // Deadline (chỉ dùng cho action_item)
    $table->string('nguoi_phu_trach')->nullable(); // Người phụ trách
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_details');
    }
};
