<?php
/*
 * Webshippy refactor exercise
 * Author: Máté Dusik
 */

declare(strict_types=1);

namespace Tests\Parameter;

use App\Parameter\ParameterParser;
use PHPUnit\Framework\TestCase;

require __DIR__.'/../../autoload.php';

/**
 * @covers \App\Parameter\ParameterParser
 */
class ParameterParserTest extends TestCase
{
    private const PARAMETERS = [
        'types' => ['json', 'int'],
        'values' => ['{"1":8,"2":4,"3":5}', 2],
        'want' => [[
            '1' => 8,
            '2' => 4,
            '3' => 5,
        ], 2],
    ];

    private const UNMATCHING_NUMBER_OF_PARAMETERS = [
        [
            'types' => ['json', 'int'],
            'values' => ['{"1":8,"2":4,"3":5}']
        ],
        [
            'types' => ['json'],
            'values' => ['{"1":8,"2":4,"3":5}', 2]
        ]
    ];

    private const MALFORMED_JSON_PARAMETER = [
        'types' => ['json'],
        'values' => ['{"1": 8, "2"'],
    ];

    public function testParameterParsing(): void
    {
        $this->setupParameters(self::PARAMETERS['values']);

        try {
            $parameterParser = new ParameterParser(self::PARAMETERS['types']);
        } catch (\Exception $exception) {
            $this->fail('Could not parse valid parameters!');
        }

        foreach (self::PARAMETERS['want'] as $i => $want) {
            $this->assertEquals($want, $parameterParser->getParameter($i));
        }

        $this->assertNull($parameterParser->getParameter(\count(self::PARAMETERS['values'])));
    }

    public function testUnmatchingNumberOfParameters(): void
    {
        foreach (self::UNMATCHING_NUMBER_OF_PARAMETERS as $case) {

            $this->setupParameters($case['values']);

            try {
                new ParameterParser($case['types']);
            } catch (\Exception $exception) {
                $this->assertEquals('Ambiguous number of parameters!', $exception->getMessage());
                continue;
            }

            $this->fail('Invalid parameter info got through');
        }
    }

    public function testMalformedJsonData(): void
    {
        $this->setupParameters(self::MALFORMED_JSON_PARAMETER['values']);

        try {
            new ParameterParser(self::MALFORMED_JSON_PARAMETER['types']);
        } catch (\Exception $exception) {
            $this->assertEquals('Invalid json!', $exception->getMessage());
            return;
        }

        $this->fail('Could not detect faulty json parameter!');
    }

    private function setupParameters(array $parameters): void
    {
        $_SERVER['argv'] = \array_merge(['scriptName'], $parameters);
        $_SERVER['argc'] = \count($parameters) + 1;
    }
}