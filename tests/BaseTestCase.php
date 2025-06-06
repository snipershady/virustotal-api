<?php

declare(strict_types=1);

namespace Virustotal\Tests;

use ErrorException;
use Exception;
use Override;
use Throwable;
use Virustotal\Dto\UploadFileDto;
use Virustotal\Service\VirustotalService;
use function error_reporting;
use function set_error_handler;

/*
 * Copyright (C) 2022 Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of BaseTestCase
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 * 
 * @example php vendor/bin/phpunit tests/BaseTestCase.php 
 */
class BaseTestCase extends AbstractTestCase {

    #[Override]
    public static function setUpBeforeClass(): void {
        set_error_handler(function ($errno, $errstr, $errfile, $errline): false {
            // error was suppressed with the @-operator
            if (0 === error_reporting()) {
                return false;
            }

            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }

    #[Override]
    protected function setUp(): void {
        parent::setUp();
    }

    /**
     * 
     * @return void
     */
    private function createVirusTotalFile(): void {
        $filePath = '/tmp/vt.txt';
        $content = 'Snipershady Virus Total';

        try {
            file_put_contents($filePath, $content, LOCK_EX);
            echo "File creato con successo: {$filePath}" . PHP_EOL;
        } catch (Throwable $e) {
            echo "Errore nella creazione del file: " . $e->getMessage() . PHP_EOL;
        }
    }

    private function getApiKey(): string {
        $envFilePath = __DIR__ . '/../.env';

        if (!file_exists($envFilePath)) {
            throw new Exception("File .env not found");
        }

        $envVariables = parse_ini_file($envFilePath);

        if (!isset($envVariables['API_KEY'])) {
            throw new Exception("Undefined key API_KEY .env");
        }

        return (string) $envVariables['API_KEY'];
    }

    public function testUploadFile(): void {
        echo "Testing: " . __FUNCTION__;
        $apiKey = $this->getApiKey();
        $this->createVirusTotalFile();
        $vts = new VirustotalService($apiKey);
        $response = $vts->uploadFile("/tmp/vt.txt");
        $ufdto = UploadFileDto::fromArray($response);
        self::assertNotEmpty($ufdto->getId());
        self::assertEquals($ufdto->getType(), "analysis");
        self::assertEquals("https://www.virustotal.com/api/v3/analyses/" . $ufdto->getId(), $ufdto->getSelfLink());
        self::assertTrue(true);
    }
}
