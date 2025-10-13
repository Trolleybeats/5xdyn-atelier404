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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('description');
            $table->enum('statut',['Nouvelle_demande','Diagnostic','En_réparations','Terminé','Non_réparable'] )->default('Nouvelle demande');
            $table->date('date_prevue')->nullable();
            $table->enum('priorité',['faible','normal','élevé','critique'])->default('normal');
            //foreign
            $table->foreignId('type_appareil_id')->constrained('type_appareils')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
