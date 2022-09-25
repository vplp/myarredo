<?php

namespace frontend\components;

class UserIp
{
    const IP_SOURCE_URL = 'http://ip-api.com';
    const RESPONSE_FORMAT = 'json';

    /**
     * @var string
     */
    private $countryCode = '';

    /**
     * @var float
     */
    private $lat = 0;

    /**
     * @var float
     */
    private $lng = 0;

    public function __construct(?string $ip)
    {
        $this->setIpAttributes($ip);
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * @param string|null $ip
     *
     * @return void
     */
    private function setIpAttributes(?string $ip): void
    {
        $ipInfo = $this->getIpInfo($ip);

        if (isset($ipInfo['countryCode'])) {
            $this->countryCode = mb_strtolower($ipInfo['countryCode']);
        }

        if (isset($ipInfo['lat'])) {
            $this->lat = (float)$ipInfo['lat'];
        }

        if (isset($ipInfo['lon'])) {
            $this->lng = (float)$ipInfo['lon'];
        }
    }

    /**
     * @param string|null $ip
     *
     * @return array
     */
    private function getIpInfo(?string $ip): array
    {
        if (!$ip) {
            return [];
        }

        $headers = [
            "Content-Type: application/json; charset=utf-8"
        ];

        $curl = curl_init();

        curl_setopt(
            $curl,
            CURLOPT_URL,
            sprintf('%s/%s/%s',self::IP_SOURCE_URL, self::RESPONSE_FORMAT, $ip)
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $ipInfo = json_decode(curl_exec($curl), true);

        if (!$ipInfo || $ipInfo['status'] === 'fail') {
            return [];
        }

        return $ipInfo;
    }
}