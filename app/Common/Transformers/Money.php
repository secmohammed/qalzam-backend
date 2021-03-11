<?php

namespace App\Common\Transformers;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as BaseMoney;
use NumberFormatter;

// use NumberFormatter;

/**
 * Money Transformer
 */
class Money
{
    /**
     * @var mixed
     */
    private $money;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->money = new BaseMoney($value, new Currency('SAR'));
    }

    /**
     * @param Money $money
     * @return mixed
     */
    public function add(Money $money)
    {
        $this->money = $this->money->add($money->instance());

        return $this;
    }

    /**
     * @return mixed
     */
    public function amount()
    {
        return $this->money->getAmount();
    }

    /**
     * @return mixed
     */
    public function formatted()
    {
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter(config('qalzam.currency'), NumberFormatter::CURRENCY),
            new ISOCurrencies
        );

        return $formatter->format($this->money);
    }

    /**
     * @return mixed
     */
    public function instance()
    {
        return $this->money;
    }
}
