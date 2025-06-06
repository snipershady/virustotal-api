<?php

declare(strict_types=1);

namespace Virustotal\Service;

use CURLFile;
use Virustotal\Exception\RestCallException;

class VirustotalService {

    private readonly string $basePath;

    public function __construct(private readonly string $apiKey) {
        $this->apiKey = $apiKey;
        $this->basePath = "https://www.virustotal.com/api/v3";
    }

    /**
     * 
     * @param string $filePath
     * @return array<string, string>
     * @throws JsonException|Exception
     */
    public function uploadFile(string $filePath): array {
        $apiKey = "123";
        $this->apiKey = $apiKey;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->basePath . '/files',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'accept: application/json',
                'content-type: multipart/form-data',
                'x-apikey: ' . $apiKey
            ],
            CURLOPT_POSTFIELDS => [
                'file' => new CURLFile($filePath)
            ]
        ]);

        $response = curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $errorMsg = curl_error($curl);
            curl_close($curl);
            throw new RestCallException("Rest call error: " . $errorMsg, $httpStatusCode);
        }

        curl_close($curl);
        $arrayResponse = json_decode($response, true, 512, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        return $arrayResponse;
    }
}
