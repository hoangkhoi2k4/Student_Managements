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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); // user_id : bigInteger : FK
            $table->string('student_code', 50)->nullable()->unique(); // student_code: varchar(50)->nullable()->unique()
            $table->string('avatar', 255)->nullable(); // avatar: varchar(255)->nullable()
            $table->string('phone', 20)->nullable()->unique(); // phone: varchar(20)->nullable()->unique()
            $table->boolean('gender')->default(true); // gender: boolean->default(true)
            $table->date('birthday')->nullable(); // birthday: date()->nullable()
            $table->bigInteger('department_id')->unsigned(); // department_id: bigInteger : FK
            $table->string('address', 100)->nullable(); // address: varchar(100)->nullable()
            $table->timestamps(); // created_at : timestamp, updated_at : timestamp
            $table->softDeletes(); // deleted_at : timestamp

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
