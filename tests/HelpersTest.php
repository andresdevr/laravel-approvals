<?php

namespace Andresdevr\LaravelApprovals\Tests;

use Andresdevr\LaravelApprovals\Traits\HasApprovals;
use Illuminate\Database\Eloquent\Model;

class HelpersTest extends TestCase
{
    /**
     * @test
     */
    public function can_validate_json()
    {
	    $json = '{"test": "test"}';
        $jsonInvalide = 'rewq';

        $this->assertTrue(isJson($json));
        $this->assertFalse(isJson($jsonInvalide));
    }
}	
