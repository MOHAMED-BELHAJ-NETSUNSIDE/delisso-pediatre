<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('medecins', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->unsignedTinyInteger('type')->default(1);
            $table->string('region')->nullable();
            $table->string('municipalite')->nullable();
            $table->unsignedTinyInteger('etab')->nullable();
            $table->string('name_etab')->nullable();
            $table->string('adresse')->nullable();
            $table->string('tel', 60)->nullable();
            $table->string('email')->nullable();
            $table->string('classe', 8)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->index('fullname');
            $table->index('region');
        });

        Schema::create('cadeaux', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('seuil_alerte')->default(10);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->index('active');
        });

        Schema::create('visites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medecin_id')->constrained('medecins');
            $table->foreignId('delegue_id')->constrained('users');
            $table->unsignedTinyInteger('nvisite')->default(1);
            $table->string('classe', 8)->nullable();
            $table->string('region')->nullable();
            $table->string('municipalite')->nullable();
            $table->unsignedTinyInteger('etab')->nullable();
            $table->string('name_etab')->nullable();
            $table->string('gps', 80)->nullable();
            $table->text('remarque')->nullable();
            $table->timestamps();
            $table->index(['delegue_id', 'created_at']);
        });

        Schema::create('visite_cadeaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visite_id')->constrained('visites')->cascadeOnDelete();
            $table->foreignId('cadeau_id')->constrained('cadeaux');
            $table->unsignedInteger('qty');
        });

        Schema::create('visite_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visite_id')->constrained('visites')->cascadeOnDelete();
            $table->string('path');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('stock_mouvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadeau_id')->constrained('cadeaux');
            $table->string('type');
            $table->integer('qty');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('visite_id')->nullable()->constrained('visites')->nullOnDelete();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_mouvements');
        Schema::dropIfExists('visite_photos');
        Schema::dropIfExists('visite_cadeaux');
        Schema::dropIfExists('visites');
        Schema::dropIfExists('cadeaux');
        Schema::dropIfExists('medecins');
        Schema::dropIfExists('etablissements');
    }
};
