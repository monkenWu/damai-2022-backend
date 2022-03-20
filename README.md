# damai-2022-backend

## 如何布署

1. 將 `.env.example` 複製為 `.env`
2. `docker-compose up`
3. 初次布署執行下列指令
    * `docker-compose exec app composer install`
    * `docker-compose exec app php artisan key:generate`
4. 開發伺服器連接埠預設為 `8080`

## 可用 API

### GET /api/quiz/exchange

匯率查詢

#### Request

##### query string
| name | type | comment | required | note |
| -------- | -------- | -------- | -------- | -------- |
| from     | string     | 來源幣別     | 是     | (USD, TWD, JPY) |
| to     | string     | 目標幣別     | 是     | (USD, TWD, JPY) |

#### Response

##### status 200

| name | type | comment | required | note |
| -------- | -------- | -------- | -------- | -------- |
| exchange_rate     | numeric     | 匯率     | 是     |  |
| updated_at     | string     | 更新時間     | 是     | 台灣時間 Y-m-d H:i:s |

##### status 400

| name | type | comment | required | note |
| -------- | -------- | -------- | -------- | -------- |
| msg     | object     | 欄位與錯誤原因     | 是     |  |
