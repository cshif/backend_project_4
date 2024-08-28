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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id');
            $table->bigInteger('user_id');
            $table->enum('type', ['deposit', 'withdraw', 'transfer']);
            $table->enum('currency_type', ['TWD', 'USD', 'JPY']);
            $table->string('note')->nullable();
            $table->decimal('balance_before_transaction', 65, 30)->nullable();
            $table->decimal('balance_after_transaction', 65, 30)->nullable();
            $table->enum('status', ['success', 'fail']);
            $table->unsignedBigInteger('source_account_id')->nullable();
            $table->unsignedBigInteger('destination_account_id')->nullable();
            $table->timestamps();

            $table
                ->foreign('source_account_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table
                ->foreign('destination_account_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
