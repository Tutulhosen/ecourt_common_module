<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->integer('cdap_user_id')->nullable();
            $table->integer('is_cdap_user')->nullable();
            $table->string('role_id')->nullable();
            $table->integer('office_id')->nullable();
            $table->integer('doptor_office_id')->nullable();
            $table->integer('doptor_user_flag')->nullable();
            $table->integer('doptor_user_active')->nullable();
            $table->integer('peshkar_active')->nullable();
            $table->integer('court_id')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('signature')->nullable();
            $table->string('citizen_id')->nullable();
            $table->string('citizen_nid')->nullable();
            $table->string('otp')->nullable();
            $table->string('email')->unique();
            $table->integer('is_verified_account')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_pic')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
