<?php

namespace App\Migrations;

use App\Core\Schema\Schema;

$schema = new Schema();

$schema->create('usersxd', function ($table) {
    $table->INT('id')->primaryKey()->autoIncrement()->defaultValue(0);
    $table->INT('user_id')->foreignKey()->references('users(id)')->nullable();
})->generate();
