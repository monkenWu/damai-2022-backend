<?php

namespace App\Repositories;

use App\Constants\CurrencyConstant;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 *
 */
class CurrencyRepository
{

    /**
     * 幣別資訊
     *
     * @var null|array
     */
    protected ?array $exchangeRateInfo = null;

    /**
     * 以 API 取得幣別資訊，並儲存在成員變數中
     *
     * @throws GuzzleException
     */
    private function initExchangeRateInfo()
    {
        $client   = new Client();
        $response = $client->get('https://tw.rter.info/capi.php');
        $this->exchangeRateInfo = json_decode($response->getBody(), true);
    }

    /**
     * 取得幣別列表 中英轉換
     * @return string[]
     */
    public function getCurrencyList()
    {
        return CurrencyConstant::CURRENCY;
    }

    /**
     * 取得美元兌換該幣別匯率
     *
     * @param String $currency 幣別 ex: TWD, JPY
     *
     * @return array|mixed [
     *                      "Exrate": 匯率
     *                      "UTC": 更新時間
     *                      ]
     * @throws GuzzleException
     */
    public function getExchangeRate(string $currency)
    {
        if (is_null($this->exchangeRateInfo)) $this->initExchangeRateInfo();
        $key      = "USD" . $currency;
        return $this->exchangeRateInfo[$key] ?? [];
    }
}
