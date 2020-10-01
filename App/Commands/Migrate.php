<?php

namespace App\Commands;

use App\Core\CLI\CommandController;
use App\Core\Schema\Schema;

class Migrate extends CommandController
{
    public function run($argv)
    {
        $schema = new Schema();

        $schema->create("users", function ($table) {
            $table->INT("id")->primaryKey()->autoIncrement()->defaultValue(0)->primaryKey();
            $table->VARCHAR("username", 144);
            $table->TEXT("bio")->nullable()->maxValue(200);
        })->generate();
    }
}
