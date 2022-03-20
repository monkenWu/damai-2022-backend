<?php

namespace App\Services;

use App\Repositories\CurrencyRepository;

/**
 *
 */
class ExchangeService
{
    private $currencyRepo;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepo = $currencyRepository;
    }

    /**
     * 取得匯率結果
     *
     * @param string $from 來源幣別
     * @param string $to 目標幣別
     * @param integer $amount
     * @return array [ "exchangeRate": 匯率 , "updateAt": 更新時間]
     */
    public function getExchangeRate(string $from, string $to, float $amount = 1): array
    {
        $fromRateData = $this->currencyRepo->getExchangeRate($from);
        $toRateData = $this->currencyRepo->getExchangeRate($to);
        $usdRate = $amount / $fromRateData['Exrate'];
        $exchangeRate = $usdRate * $toRateData['Exrate'];
        $updatedAt = \Carbon\Carbon::parse($toRateData['UTC'], 'UTC')->setTimezone('Asia/Taipei')->toDateTimeString();
        return [
            "exchangeRate" => $exchangeRate,
            "updateAt" => $updatedAt
        ];
    }
}
