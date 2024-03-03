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
        // 主キーの命名がLaravelの規則に倣ってなかったため是正する
        Schema::table('projects', function (Blueprint $table) {
            $table->renameColumn('project_id', 'id');
        });

        Schema::table('project_details', function (Blueprint $table) {
            $table->renameColumn('project_detail_id', 'id');
        });

        Schema::table('project_member_details', function (Blueprint $table) {
            $table->renameColumn('project_member_detail_id', 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
        $table->renameColumn('id', 'project_id');
        });

        Schema::table('project_details', function (Blueprint $table) {
            $table->renameColumn('id', 'project_detail_id');
        });

        Schema::table('project_member_details', function (Blueprint $table) {
            $table->renameColumn('id', 'project_member_detail_id');
        });
    }
};
