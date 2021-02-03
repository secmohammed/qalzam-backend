<?php

namespace App\Common\Transformers;

use Money\Currency;
use NumberFormatter;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

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
        $this->money = new BaseMoney($value, new Currency('EGP'));
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
