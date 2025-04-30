<?php

use Flarum\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return Migration::createTable(
    'post_bonus',
    function (Blueprint $table) {
        $table->increments('id');
        $table->integer('post_id')->unsigned();
        $table->integer('user_id')->unsigned();
        $table->timestamp('created_at')->useCurrent()->nullable(false);
    }
);
