<?php

use App\Enums\UserAccountStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_photo_path', 2048)->nullable();
            $table->unsignedBigInteger('department');
            $table->index('department', 'users_user_department_foreign');
            $table->enum('account_status', array_map(fn($case) => $case->value, UserAccountStatus::cases()))->default(UserAccountStatus::Active->value);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->index('created_by', 'users_created_by_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
