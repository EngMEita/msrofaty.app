<?php

namespace JMac\Testing\Traits;

trait AdditionalAssertions
{
    public function assertActionUsesFormRequest(string $controller, string $method, string $request): void
    {
        $reflection = new \ReflectionMethod($controller, $method);
        $parameters = array_map(fn ($parameter) => $parameter->getType()?->getName(), $reflection->getParameters());
        $this->assertContains($request, $parameters);
    }
}
