<?php

use App\Models\CoffeePot;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->cascadeOnDelete()->change();
            $table->foreignIdFor(CoffeePot::class)->cascadeOnDelete()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->change();
            $table->foreignIdFor(CoffeePot::class)->change();
        });
    }
};
