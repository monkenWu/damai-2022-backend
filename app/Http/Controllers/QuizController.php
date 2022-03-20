<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ExchangeResource;
use App\Http\Resources\BadQueryResource;
use App\Services\ExchangeService;
use App\Constants\CurrencyConstant;
use Illuminate\Validation\Rule;


/**
 *
 */
class QuizController extends Controller
{
    private $exchangeService;

    public function __construct(
        ExchangeService $exchangeService
    ) {
        $this->exchangeService = $exchangeService;
    }

    public function getExchangeRate(Request $request)
    {
        // 資料檢查
        try {
            $allowInpups = array_values(CurrencyConstant::CURRENCY);
            $request->validate([
                'from' => ['required', 'string', Rule::in($allowInpups)],
                'to' => ['required', 'string', Rule::in($allowInpups)]
            ]);
        } catch (ValidationException $exception) {
            $validatorInstance = $exception->validator;
            $errorMessageData = $validatorInstance->getMessageBag();
            $errorMessages = $errorMessageData->getMessages();
            $resource = collect($errorMessages);
            return (new BadQueryResource($resource))->response()->setStatusCode(400);
        }
        $from = $request->query('from');
        $to = $request->query('to');

        //取得結果
        $resource = collect($this->exchangeService->getExchangeRate($from, $to));

        return new ExchangeResource($resource);
    }
}
