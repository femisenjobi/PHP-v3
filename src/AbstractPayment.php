<?php

namespace Flutterwave;

use Flutterwave\EventHandlers\EventHandlerInterface;
use Flutterwave\Traits\ApiOperations as Api;
use Flutterwave\Traits\PayloadOperations as Payload;
use Psr\Log\LoggerInterface;

abstract class AbstractPayment
{
    use Api\Post, Api\Get, Payload\Prepare;

    public string $secretKey;
    public string $txref;
//    protected ?string $integrityHash = null;
    protected string $payButtonText = 'Proceed with Payment';
    protected string $redirectUrl;
    protected array $meta = array();
    //protected $env;
    protected string $transactionPrefix;
    // public $logger;
    protected EventHandlerInterface $handler;
    protected string $baseUrl;
    protected string $transactionData;
    protected string $overrideTransactionReference;
    protected int $requeryCount = 0;
    protected static ?array $methods = null;

    //Payment information
    protected $account;
    protected $key;
    protected $pin;
    protected $options;
    protected string $amount;
    protected $paymentOptions = Null;
    protected $customDescription;
    protected $customLogo;
    protected $customTitle;
    protected $country;
    protected $currency;
    protected $customerEmail;
    protected $customerFirstname;
    protected $customerLastname;
    protected $customerPhone;

    //EndPoints
    protected string $end_point;
    protected string $flwRef;
    public $type;
    /**
     * @var LoggerInterface
     */
    public LoggerInterface $logger;
    /**
     * @var Helper\Config
     */
    protected static Helper\Config $config;

    public function __construct()
    {
        self::$config = Helper\Config::getInstance(
            $_SERVER[Helper\Config::SECRET_KEY],
            $_SERVER[Helper\Config::PUBLIC_KEY],
            $_SERVER[Helper\Config::ENCRYPTION_KEY],
            $_SERVER['ENV']
        );
    }

    abstract public function initialize();

}