<?php

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
        // Laravelの推奨する中間テーブルの構成に修正
        Schema::rename('project_members', 'project_user');
        Schema::table('project_user', function (Blueprint $table) {
            $table->renameColumn('project_member_id', 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('project_user', 'project_members');
        Schema::table('project_members', function (Blueprint $table) {
            $table->renameColumn('id', 'project_member_id');
        });
    }
};
