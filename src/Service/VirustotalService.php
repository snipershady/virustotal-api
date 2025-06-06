<?php

declare(strict_types=1);

namespace Virustotal\Service;

use CURLFile;
use CurlHandle;
use JsonException;
use RuntimeException;
use Virustotal\Dto\FileAnalysisDto;
use Virustotal\Dto\UploadFileDto;
use Virustotal\Exception\RestCallException;
use function curl_close;
use function curl_error;
use function curl_exec;
use function curl_getinfo;
use function curl_init;
use function curl_setopt_array;
use function json_decode;

class VirustotalService {

    private readonly string $basePath;

    public function __construct(private readonly string $apiKey) {
        $this->basePath = "https://www.virustotal.com/api/v3";
    }

    /**
     * 
     * @param string $filePath
     * @return FileAnalysisDto
     * @throws JsonException
     * @throws RestCallException
     * @throws RuntimeException
     */
    public function uploadFileAndAnalyze(string $filePath): FileAnalysisDto {
        return $this->analyze($this->uploadFile($filePath));
    }

    /**
     * 
     * @param string $url
     * @return FileAnalysisDto
     * @throws JsonException
     * @throws RestCallException
     * @throws RuntimeException
     */
    public function scanUrlAndAnalyze(string $url): FileAnalysisDto {
        return $this->analyze($this->scanUrl($url));
    }

    /**
     * 
     * @param string $url
     * @return UploadFileDto
     * @throws JsonException
     * @throws RestCallException
     * @throws RuntimeException
     */
    public function scanUrl(string $url): UploadFileDto {
        $postFields = http_build_query(['url' => $url]);

        $curl = curl_init();
        if ($curl === false) {
            throw new RuntimeException("cURL init Error");
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->basePath . '/urls',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'accept: application/json',
                'content-type: application/x-www-form-urlencoded',
                'x-apikey: ' . $this->apiKey
            ],
            CURLOPT_POSTFIELDS => $postFields
        ]);

        return UploadFileDto::fromArray($this->getResponse($curl));
    }

    /**
     * 
     * @param string $filePath
     * @return UploadFileDto
     * @throws JsonException
     * @throws RestCallException
     * @throws RuntimeException
     */
    public function uploadFile(string $filePath): UploadFileDto {

        $curl = curl_init();
        if ($curl === false) {
            throw new RuntimeException("cURL init Error");
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->basePath . '/files',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'accept: application/json',
                'content-type: multipart/form-data',
                'x-apikey: ' . $this->apiKey
            ],
            CURLOPT_POSTFIELDS => [
                'file' => new CURLFile($filePath)
            ]
        ]);

        return UploadFileDto::fromArray($this->getResponse($curl));
    }

    /**
     * 
     * @param UploadFileDto $uploadFileDto
     * @return FileAnalysisDto
     */
    public function analyze(UploadFileDto $uploadFileDto): FileAnalysisDto {
        $curl = curl_init();
        if ($curl === false) {
            throw new RuntimeException("cURL init Error");
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->basePath . '/analyses/' . $uploadFileDto->getId(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'accept: application/json',
                'x-apikey: ' . $this->apiKey
            ],
        ]);
        return FileAnalysisDto::fromArray($this->getResponse($curl));
    }

    /**
     * 
     * @param CurlHandle $curl
     * @return array<string, null|string|int>
     * @throws RestCallException
     */
    private function getResponse(CurlHandle $curl): array {
        $response = curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($httpStatusCode === 401) {
            throw new RestCallException("Rest call error. Invalid Credential: " . $response, $httpStatusCode);
        }
        
        if ($httpStatusCode > 299 || $response === false) {
            $errorMsg = curl_error($curl);
            curl_close($curl);
            throw new RestCallException("Rest call error: " . $errorMsg, $httpStatusCode);
        }

        curl_close($curl);
        $arrayResponse = json_decode((string) $response, true, 512, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        return $arrayResponse;
    }
}
