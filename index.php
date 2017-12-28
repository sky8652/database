<?php

use Waitmoonman\Database\DB;

require 'vendor/autoload.php';

DB::addConnection(require __DIR__ . '/config/database.php');



$users = DB::table('users')->insert(['name' => 'gps', 'email' => '1223@qq.com', 'password' => '123456']);

var_dump($users);