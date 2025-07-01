<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;


class FibonacciService
{
    /**
     * 2x2 行列の積（bcmath 使用）
     *
     * @param array<array<string>> $a
     * @param array<array<string>> $b
     * @return array<array<string>>
     */
    private function product_bcmath(array $a, array $b): array
    {
        $n = 2;
        $c = [
            ['0', '0'],
            ['0', '0'],
        ];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                for ($k = 0; $k < $n; $k++) {
                    $mul = bcmul($a[$i][$k], $b[$k][$j]);
                    $c[$i][$j] = bcadd($c[$i][$j], $mul);
                }
            }
        }
        return $c;
    }


    private function computeFibonacci(int $N): string
    {
        $S = strrev(decbin((int)$N));
        $M = strlen($S);

        $L = [
            [
                ['1', '1'],
                ['1', '0']
            ]
        ];

        for ($i = 1; $i < $M; $i++) {
            $L[] = $this->product_bcmath($L[$i - 1], $L[$i - 1]);
        }

        $R = [
            ['1', '0'],
            ['0', '1']
        ];

        for ($i = 0; $i < $M; $i++) {
            if ($S[$i] === '1') {
                $R = $this->product_bcmath($R, $L[$i]);
            }
        }

        return $R[0][1];
    }

    public function fibonacci(int $N): string
    {
        $key = "fibonacci_$N";

        // キャッシュから取得
        return Cache::remember($key, now()->addMinutes(60), function () use ($N) {
            return $this->computeFibonacci($N);
        });
    }
}
