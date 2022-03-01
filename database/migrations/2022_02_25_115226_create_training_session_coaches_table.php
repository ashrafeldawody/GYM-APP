<?php

use App\Models\Coach;
use App\Models\TrainingSession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingSessionCoachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_session_coaches', function (Blueprint $table) {
            $table->foreignId('coach_id')->constrained();
            $table->foreignId('training_session_id')->constrained();
            $table->foreignId('gym_manager_id')->references('id')->on('gym_managers');
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
