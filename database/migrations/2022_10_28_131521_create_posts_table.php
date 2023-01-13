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
        Schema::create('posts', function (Blueprint $table) {
            $table->softDeletes();
            $table->char('id',26);
            $table->primary('id');
            $table->char('author',26);
            $table->foreign('author')
                ->references('ulid')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title',20);
            $table->string('content');
            $table->integer('scope');
            $table->boolean('is_draft');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('posts');
    }
};
