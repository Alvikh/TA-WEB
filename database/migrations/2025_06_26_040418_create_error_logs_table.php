<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->text('exception')->nullable();
            $table->string('code')->nullable();
            $table->string('file');
            $table->integer('line');
            $table->text('trace')->nullable();
            $table->string('url')->nullable();
            $table->string('method')->nullable();
            $table->json('input')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('error_logs');
    }
};