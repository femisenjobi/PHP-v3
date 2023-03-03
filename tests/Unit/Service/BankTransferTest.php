<?php

namespace Unit\Service;

use Flutterwave\Test\Resources\Setup\Config;
use Flutterwave\Flutterwave;
use Flutterwave\Util\AuthMode;
use PHPUnit\Framework\TestCase;
use Flutterwave\Util\Currency;


class BankTransferTest extends TestCase
{
    protected function setUp(): void
    {
        Flutterwave::bootstrap(
            Config::setUp(
                getenv(Config::SECRET_KEY),
                getenv(Config::PUBLIC_KEY),
                getenv(Config::ENCRYPTION_KEY),
                getenv(Config::ENV)
            )
        );
    }

    public function testAuthModeReturnBankTransfer()
    {
        $data = [
            "amount" => 2000,
            "currency" => Currency::NGN,
            "tx_ref" => uniqid().time(),
            "redirectUrl" => "https://google.com"
        ];

        $btpayment = Flutterwave::create("bank-transfer");
        $customerObj = $btpayment->customer->create([
            "full_name" => "Olaobaju Jesulayomi Abraham",
            "email" => "developers@flutterwavego.com",
            "phone" => "+2349067985011"
        ]);

        $data['customer'] = $customerObj;
        $payload  = $btpayment->payload->create($data);
        $result = $btpayment->initiate($payload);
        $this->assertSame(AuthMode::BANKTRANSFER, $result['mode']);
    }
}