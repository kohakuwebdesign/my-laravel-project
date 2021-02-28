<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->bigInteger('data_id')->nullable()->comment('投稿に付加されているID');
            $table->text('text')->nullable()->comment('本文');
            $table->dateTime('data_created_at')->nullable()->comment('ツイート日時');
            $table->text('media_url')->nullable()->comment('メディアURL');
            $table->text('embed_tag')->nullable()->comment('埋め込みタグ');
            $table->boolean('is_published')->default(0)->comment('公開状態');
            $table->boolean('is_deleted')->default(0)->comment('論理削除');
            $table->integer('prefecture_id')->nullable()->comment('都道府県ID');
            $table->integer('animal_id')->nullable()->comment('動物の種類ID');
            $table->integer('state_id')->nullable()->comment('動物の状態のID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
