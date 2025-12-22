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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Link to the Customer (The "Owner")
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            
            // Link to the Staff who created it (Optional)
            $table->foreignId('created_by_user_id')->nullable()->constrained('users');
            
            $table->string('status')->default('Draft'); 
            
            // --- ORDER DETAILS ---
            $table->date('order_date');                         
            $table->decimal('total_amount', 12, 2)->default(0); 
            $table->text('notes')->nullable();   
            $table->foreignId('designer_id')->nullable()->constrained('users');
            $table->string('invoice_number')->unique()->nullable();               
            
            // --- THE SNAPSHOT COLUMN (New!) ---
            // This stores the address *at the time of the order*
            $table->text('shipping_address')->nullable(); 
            $table->string('design_file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};