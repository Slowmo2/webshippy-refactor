<?php

namespace App\Parameter;

final class ParameterParser
{
    public const TYPE_JSON = 'json';

    private int $parameterCount;
    private array $parameters;
    private array $parsedParameters = [];

    /**
     * @param string[] $parameterTypes
     */
    public function __construct(array $parameterTypes = [])
    {
        $this->parameterCount = $_SERVER['argc'];
        $this->parameters = $_SERVER['argv'];

        if ($this->parameterCount !== \count($parameterTypes) + 1) { // adding 1 because of the script name as first parameter
            throw new \LogicException('Ambiguous number of parameters!');
        }

        $this->parseParameters($parameterTypes);
    }

    private function parseParameters(array $parameterTypes): void
    {
        foreach ($parameterTypes as $i => $type) {
            switch ($type) {
                case self::TYPE_JSON:
                    $this->parsedParameters[] = $this->parseJsonParameter($i + 1);
                default:
                    $this->parsedParameters[] = $this->parameters[$i + 1] ?? null;
            }
        }
    }

    private function parseJsonParameter(int $index)
    {
        if (!isset($this->parameters[$index])) {
            throw new \Exception(\sprintf('Parameter with the index of %d not found!', $index));
        }

        if (($parameter = \json_decode($this->parameters[$index])) === null) {
            throw new \LogicException('Invalid json!');
        }

        return $parameter;
    }

    public function getParameter(int $index)
    {
        return $this->parsedParameters[$index] ?? null;
    }
}