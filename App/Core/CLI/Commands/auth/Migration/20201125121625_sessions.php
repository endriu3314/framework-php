<?php

namespace App\Migrations;

use App\Core\Schema\Schema;

$schema = new Schema();

$schema->create('sessions', function ($table) {
    $table->VARCHAR('session_id', '255')->primaryKey();
    $table->BIGINT('user_id');
    $table->TIMESTAMP('login_time')->defaultValue('CURRENT_TIMESTAMP');
})->generate();
