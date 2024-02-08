<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewfieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_category')->after('id')->nullable()->default('0');
            $table->string('owner')->after('profile_photo')->nullable();
            $table->string('established')->after('profile_photo')->nullable();
            $table->string('hourly_rate')->after('profile_photo')->nullable();
            $table->integer('country')->after('id')->nullable()->default('0');
            $table->string('address')->after('profile_photo')->nullable();
            $table->string('postalcode')->after('profile_photo')->nullable();
            $table->decimal('latitude', 10, 7)->after('profile_photo')->nullable();
            $table->decimal('longitude', 10, 7)->after('profile_photo')->nullable();
            $table->string('phone')->after('email')->nullable();
            $table->text('description')->after('email')->nullable();
            $table->json('social')->after('email')->nullable();
            $table->tinyInteger('gender')->after('name')->nullable()->default('0');
            $table->decimal('balance', 10, 2)->after('description')->nullable()->unsigned()->default('0');
            // $table->decimal('hourly_rate', 10, 2)->after('description')->nullable()->unsigned()->default('0.00');
            $table->string('time_rate', 50)->after('description')->nullable();
            $table->string('verify', 100)->after('email_verified_at')->nullable();
            $table->text('reason')->after('email')->nullable();
            $table->tinyInteger('approve')->unsigned()->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
