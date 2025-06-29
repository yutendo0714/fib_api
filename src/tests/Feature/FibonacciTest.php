<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

const N = 99;
const RESULT = 218922995834555169026;

class FibonacciTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_api_valid_input()
    {
        $response = $this->get('/fib?n=' . N);

        $response->assertStatus(200);
        $response->assertJson([
            'result' => RESULT,
        ]);
    }

    public function test_api_invalid_input()
    {
        $response = $this->get('/fib?n=abc');

        $response->assertStatus(400);
        $response->assertJson([
            'status' => 400,
            'message' => 'Bad request.',
        ]);
    }
}
