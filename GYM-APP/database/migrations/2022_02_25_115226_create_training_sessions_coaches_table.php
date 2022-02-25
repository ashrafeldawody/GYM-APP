<?php

use App\Models\TrainingSession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingSessionsCoachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_sessions_coaches', function (Blueprint $table) {
            $table->foreignId('training_session_id')->references('id')->on('training_sessions')->onUpdate('cascade');
            $table->foreignId('coach_id')->references('id')->on('users')->onUpdate('cascade');
            $table->primary(['training_session_id', 'coach_id']);
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
        Schema::dropIfExists('training_sessions_coaches');
    }
}
