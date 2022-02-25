<?php

use App\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->foreignId('training_session_id')->references('id')->on('training_sessions')->onUpdate('cascade');
            $table->foreignIdFor(Client::class);
            $table->time('attendance_time');
            $table->date('attendance_date');
            $table->primary(['training_session_id', 'client_id']);
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
        Schema::dropIfExists('attendence');
    }
}
