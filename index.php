<?php

use Waitmoonman\Database\DB;

require 'vendor/autoload.php';

DB::addConnection(require __DIR__ . '/config/database.php');


$users = DB::table('users')->select('id', 'name', 'sex')->where('id', '>' ,1)->where('sex', 0)->first();

var_dump($users);