<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_employee', function (Blueprint $table)
        {
            $table->id();
            $table->integer('area_id');
            $table->integer('role_id');
            $table->foreign('area_id')->references('id')->on('tb_area');
            $table->foreign('role_id')->references('id')->on('tb_role');
            $table->string('nik', 12)->unique();
            $table->string('nama');
            $table->tinyInteger('status')->default(1);
            $table->string('password');
            $table->rememberToken();
            $table->string('created_by', 12)->nullable()->index();
            $table->timestamp('created_at')->nullable();
            $table->string('updated_by', 12)->nullable()->index();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_employee');
    }
};
