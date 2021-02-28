<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_states', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('g_map_api_daily_count')->comment('本日のGoogle map api使用回数');
            $table->tinyInteger('g_map_api_limit')->default(10)->comment('Google map apiの1日のリミット使用回数');
            $table->string('twitter_dog_keyword')->comment('犬情報を集めるTwitterの検索キーワード');
            $table->string('instagram_dog_keyword')->comment('犬情報を集めるInstagramの検索キーワード');
            $table->tinyInteger('instagram_search_limit')->default(10)->comment('Instagram api の検索件数リミット');
            $table->string('twitter_cat_keyword')->comment('猫情報を集めるTwitterの検索キーワード');
            $table->string('instagram_cat_keyword')->comment('猫情報を集めるInstagramの検索キーワード');
            $table->tinyInteger('twitter_search_limit')->default(10)->comment('Twitter api の検索件数リミット');
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
        Schema::dropIfExists('admin_states');
    }
}
