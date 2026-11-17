<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_basic_test(): void
    {
        $this->get('/')->assertStatus(200);
    }
}
