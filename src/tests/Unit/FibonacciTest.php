<?php

namespace Tests\Unit;

use App\Services\FibonacciService;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

const N = 99;
const RESULT = 218922995834555169026;

class FibonacciTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_fibonacci()
    {
        $service = new FibonacciService();
        $result = $service->fibonacci(N);

        $this->assertEquals(RESULT, $result); // フィボナッチ10項目 = 55
    }

    public function test_fibonacci_with_cached()
    {
        Cache::flush(); // キャッシュをクリアしておく

        $service = new FibonacciService();

        // 最初の呼び出し（キャッシュされる）
        $result1 = $service->fibonacci(N);

        // Redisに入ってるか確認
        $this->assertTrue(Cache::has('fibonacci_' . N));

        // 2回目の呼び出し（キャッシュから返る）
        $result2 = $service->fibonacci(N);

        $this->assertEquals($result1, $result2);
    }
}
