<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Waitmoonman\Database\DB;

class ConnectTest extends TestCase
{
    public function testConnect()
    {
        $user = DB::table('users')->first();

        $this->assertTrue((bool) $user);
    }

}