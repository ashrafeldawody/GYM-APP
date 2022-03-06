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
            $table->foreignId('training_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('manager_id')->constrained();
            $table->primary(['training_session_id', 'coach_id']);
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
