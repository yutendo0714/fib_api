# fib_api

## 概要

指定された順番のフィボナッチ数を返すシンプルなREST APIです。  
HTTP GETメソッドで数列のインデックスを指定すると、その位置にあるフィボナッチ数を返します。

---

## ソースコード構成

```
app/
├── Exceptions/
│ └── Handler.php # 例外ハンドリング（バリデーション・認証など）
├── Http/
│ ├── Controllers/
│ │ └── FibonacciController.php # フィボナッチAPIのエンドポイント制御
│ └── Requests/
│ └── FibonacciRequest.php # 入力バリデーション
├── Services/
│ └── FibonacciService.php # フィボナッチ数列のロジック（BCMath使用）
routes/
└── api.php # APIルート定義（/fib）
storage/
├── logs/
│ └── laravel-yyyy-mm-dd.log # ログ出力
tests/
├── Feature/
│ └── FibonacciTest.php # 機能テスト
└── Unit/
└── FibonacciTest.php # 単体テスト
```

---

## エンドポイント

### `GET /fib`

#### クエリパラメータ

| パラメータ | 型     | 必須 | 説明                              |
|------------|--------|------|-----------------------------------|
| `n`        | 整数   | はい | フィボナッチ数列のインデックス（0以上） |

## リクエスト例

GET http://your-domain.com/fib?n=99

## レスポンス例

### 成功時（ステータスコード: 200）

```json
{
  "result": 218922995834555169026
}
```

### エラー時（ステータスコード: 400）

```json
{
  "status": 400,
  "message": "Bad request."
}
```

## curl コマンド例

```bash
curl -X GET "http://your-domain.com/fib?n=99" \
     -H "Content-Type: application/json"
```