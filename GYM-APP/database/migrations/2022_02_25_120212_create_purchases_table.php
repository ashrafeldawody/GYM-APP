<?php

use App\Models\Client;
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
            $table->foreignIdFor(TrainingPackage::class);
            $table->foreignId('manager_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreignIdFor(Client::class);
            $table->foreignIdFor(Gym::class);
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
