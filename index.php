<?php

use Waitmoonman\Database\DB;

require 'vendor/autoload.php';

DB::addConnection(require __DIR__ . '/config/database.php');


DB::table('users');