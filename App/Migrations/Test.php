<?php

namespace App\Migrations;

use App\Core\Schema\Schema;

$schema = new Schema();

$schema->create("users", function ($table) {
    $table->INT("id")->primaryKey()->autoIncrement()->defaultValue(0)->primaryKey();
    $table->VARCHAR("username", 144);
    $table->TEXT("bio")->nullable()->maxValue(200);
})->generate();
