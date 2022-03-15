<?php

namespace EasyWeChat\Tests\Pay;

use EasyWeChat\Pay\Contracts\Merchant;
use EasyWeChat\Pay\ResponseValidator;
use EasyWeChat\Tests\TestCase;
use Nyholm\Psr7\Response;

/**
 * Class ResponseValidatorTest.
 *
 * @package EasyWeChat\Tests\Pay
 *
 * @author 读心印 <aa24615@qq.com>
 */
class ResponseValidatorTest extends TestCase
{
    protected $privateKey = '-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQC63CKIxVMaGrnk
jBBsiF7GyiYDdvRQnOpwYAyk7AquId/pFotIm0iTrA+MRugXmIrrK0xAtlHpP6bD
UF/WMSxwzYj6bHhiK4JkBjWASSjsrAswA81XEgh2IGCUujixly7d8ZwMbnE5jenr
xdkTQuo72RdBDW3YkUC42fRe4M/zSJ4EpjJSe0WZ4CeSJmTM19mVjZ79HFACtJb+
Qg0lgPC3tFalPc7zkUYJJ6HNDIQvn62P8fRUJlT8sKllmAA82i8OfT/uA/LCPz6M
MLjf2luS/1PLsuLNaQBxfloTwxFSD9qPrTHVhZCU1q+kHFfFMHiSrPjfXzJulmqE
VhN332PHAgMBAAECggEBAKEAk/DstJHFfW5jELOzPJZkDyTlFdVvnsB8wehISVuI
bHlVp2VEBuDWW/8uCURrdybyA52ueh1TbsjTNABGFliLf/7l/0P24T516xtB7jUe
d/VDEWZ4bzn4477CRZ8e+I7bYu2DK6O/l1JDAqsJ+PDgOJ0giQkU/oNHqLsnUYX4
DauwT7OGWUoufq44SMrEicrR1udyD2uqJyrMIbWapWqUtqivzOrROFDICRmF7Kjg
OOlxfJFYfjX/WqyY9VtB116Ftev4ZFomxVdlmwqyRkfZXIP72GWuD5aeAeL9ThQS
M94091Lnh1kgYtmfFEiWmyCzwKcfCVC3D1QuRNTj9iECgYEA7SdgWGPbpP3YoqVd
4dEVFkC27xUSx0OSgGvL/4W8M9G/6XPBONHaSGN89Ahk6OOH7TSUUJyJa9pou3Jr
VeMMQJ5cP1+Ly48QQjp6E2fiUJRr/k8cU6hMV0KyAiyLwCbbBMx0sUsOUiDt+I8g
pKmlSigRXOTGm+m1x5iGkKRiXkUCgYEAybWWGQWJLHCLbFmTJbSh8Aj3idZC6nIX
k1376tW78n9ORpROhLYGQlkxf22mwzdJ9PA8hHWQQUp6McD2b3fbOt8yHmp2aSkW
N3aH1L429s0t/6IpFNwAgsoqHOPda9Hbq2reBhl+wmmAUR9iKstp8VNYx1xlHwi/
V4XRGi18EJsCgYEAzsdxm0BeiIsJtC9KH5aFs2Rz3RzbxcDmYXEca0z5X5l4ox5a
EKfxkwKkNceH7QRPRYV9+Je0vsSuYxqN+lJBIaqytlMh+jhgrc59GKSQ0T/ItfHW
uh7ZiZBO09RxefanK5T1/ox6DSRHOl3Z0ZlV1MYA9aVIgzORW1pjooSifJ0CgYAd
VmfqY7+70vK0Y6LfTRJwkx1N0vgQmV+Mc5L8aPHZJ2L/KPrymnb2l3p3ij9DDXuY
QIjMyzycAnUbX3F4bPpZ6bSkb9+hE/TDRF4lNzVPWDBkifVnr0fzveu6H/pIgFFu
8TAxuuuQ4z9ijSn+B2/1RaYX+PxMMz2BQVlUcWEmGQKBgQDAJYu4r98klCe70/wl
DuxMbb/357sKsfM/t38fepKYZ1qNUnnoTVcMpIbHPQlMFqZvvCTf479hf5WykOD2
5W06mW3l8so4JM1Z70c4Hq5J/thFZU56pdfWkMnkVqf6Zy09ZU1YMgCgp9jX9hZD
Yy2nFxJrgkaRM8ZC4zdypznV+g==
-----END PRIVATE KEY-----';

    public function test_validate()
    {
        $merchant = \Mockery::mock(Merchant::class);

        $merchant->shouldReceive('getPrivateKey')->andReturn($this->privateKey);

        $responseValidator = new ResponseValidator($merchant);

        $headers = [
            'Wechatpay-Timestamp' => 1646223453,
            'Wechatpay-Nonce' => 'c978e38a0610f35d992861b82cbe5ddb',
            'Wechatpay-Signature' => 'g9WI0r1TPKWQTuIbhpgl26i+u3JhizvoqK5OEnfv3KwfoZIne2CkK1aB3u10SPLrO8mzLfnzTlDKG+52V81DTq0E+cycUNzGIYzqwTzzeuRAneZ12HvOGWitgzL+AU3+B+gDsUaCYHqvBfL91noMh1eoziylG7usAmrwW+7Ttk5UV0lNISyWisOxRV7Ytr2+FPnSu6230sVBUtZhL3O0qQeLIROwwQ4Uv7Et9vHMVPzDNRd9cYMek2PZdS7/x+698OPi55vAvkQIuCvGVWRoEb4prxQ/oL/bfDFRGY6g/CUlrqEaaecGJUEnrwI/AbBMltPRfRHJ/6jIIerRlj0bTA=='
        ];

        $body = fopen(__DIR__.'/../stubs/files/pay_demo.json', 'r');

        $response = new Response(200, $headers, $body);

        $this->assertSame(true, $responseValidator->validate($response));
    }

    public function test_validate_is_false()
    {
        $merchant = \Mockery::mock(Merchant::class);
        $merchant->shouldReceive('getPrivateKey')->andReturn($this->privateKey);

        $responseValidator = new ResponseValidator($merchant);

        $headers = [
            'Wechatpay-Timestamp' => 1646223453,
            'Wechatpay-Nonce' => 'c978e38a0610f35d992861b82cbe5ddb',
            'Wechatpay-Signature' => 'PWx/qtlX0pEEj3FNxps03+7mIM/MhOfFqEZXIzDMl8l1NBdy9HNznmvkkzwCig3b607tfyjxQHmybncTEcO7EyDUZ+UkQ+T9NtkeL6peXLBH9jpZSw+xQYpGJw84jb7RFqeC/sU2pimlzDaGuH524K50Yka6QtnlXeARVKygz8BSYl7pUxB3Hlgf33naF1dw2aebMshqXxISNj0WBOO/Yu1hBX/MnPbZdpXzBR0gS3Si6L62SEpX8nJ8rtXFSj3SBNY/El4zoKIO3I7tf6Nn5H8xAKCGNafedXlawpFkSJWDe4amfk7dsuPtH9v3l+lTGjM6xOdrosdrv062NUGDWA==',
        ];
        $body = fopen(__DIR__.'/../stubs/files/pay_demo.json', 'r');

        $response = new Response(200, $headers, $body);

        $this->assertSame(false, $responseValidator->validate($response));
    }
}
