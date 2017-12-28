<?php

use Waitmoonman\Database\DB;

require 'vendor/autoload.php';

DB::addConnection(require __DIR__ . '/config/database.php');



$users = DB::table('users')->find(1);

var_dump($users);