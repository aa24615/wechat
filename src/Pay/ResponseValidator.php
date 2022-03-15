<?php

declare(strict_types=1);

namespace EasyWeChat\Pay;

use EasyWeChat\Pay\Contracts\Merchant as MerchantInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseValidator implements \EasyWeChat\Pay\Contracts\ResponseValidator
{
    public function __construct(protected MerchantInterface $merchant)
    {
    }

    public function validate(ResponseInterface $response): bool
    {
        $timestamp = $response->getHeader('Wechatpay-Timestamp')[0] ?? '';
        $nonce = $response->getHeader('Wechatpay-Nonce')[0] ?? '';
        $signature = $response->getHeader('Wechatpay-Signature')[0] ?? '';
        $body = $response->getBody()->getContents();

        $message = $timestamp . "\n" . $nonce . "\n" . $body . "\n";

        \openssl_sign($message, $sign, $this->merchant->getPrivateKey(), 'sha256WithRSAEncryption');

        if ($signature === base64_encode($sign)) {
            return true;
        }

        return false;
    }
}
