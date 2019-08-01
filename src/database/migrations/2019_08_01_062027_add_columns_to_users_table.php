<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('icon_file')->after('name');
            $table->bigInteger('num_of_likes')->after('icon_file')->nullable();
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('password');
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
            $table->dropColumn('icon_file');
            $table->dropColumn('num_of_likes');
            $table->string('email')->after('name')->unique();
            $table->timestamp('email_verified_at')->after('email')->nullable();
            $table->string('password')->after('email_verified_at');
        });
    }
}
