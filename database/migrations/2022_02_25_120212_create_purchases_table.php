<?php

use App\Models\User;
use App\Models\Gym;
use App\Models\TrainingPackage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('training_package_id')->constrained();
            $table->unsignedInteger('amount_paid');
            $table->unsignedInteger('sessions_number');
            $table->foreignId('manager_id')->constrained();
            $table->foreignId('gym_id')->constrained();
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
        Schema::dropIfExists('purchases');
    }
}
