<?php

namespace App\Migrations;

use App\Core\Schema\Schema;

$schema = new Schema();

$schema->create('users', function ($table) {
    $table->BIGINT('id')->primaryKey()->autoIncrement()->defaultValue(0);
    $table->VARCHAR('username', 144);
    $table->TEXT('bio')->nullable()->maxValue(200);
})->generate();
