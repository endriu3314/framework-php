<?php

namespace App\Migrations;

use App\Core\Schema\Schema;

$schema = new Schema();

$schema->create('old/Test3', function ($table) {
    $table->BIGINT('id')->primaryKey()->autoIncrement();

})->generate();
