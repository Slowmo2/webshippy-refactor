<?php

namespace App\Command;

final class Command
{
    private int $parameterCount;
    private array $parameters;

    public function __construct(?int $requiredParameterCount = null)
    {
        $this->parameterCount = $_SERVER['argc'];
        $this->parameters = $_SERVER['argv'];

        if ($requiredParameterCount !== null && $this->parameterCount !== $requiredParameterCount) {
            throw new \LogicException('Ambiguous number of parameters!');
        }
    }

    public function getJsonParameter(int $index): array|object
    {
        if (!isset($this->parameters[$index])) {
            throw new \Exception(\sprintf('Parameter with the index of %d not found!', $index));
        }

        if (($parameter = \json_decode($this->parameters[$index])) === null) {
            throw new \LogicException('Invalid json!');
        }

        return $parameter;
    }
}