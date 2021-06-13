<?php

namespace Tests\Domain\Register\Http;

use App\Domain\Register\RegisterService;
use Generator;
use Tests\TestCase;

class Register_Validations_Test extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $mockService = $this->createMock(RegisterService::class);
        $this->app->bind(RegisterService::class, fn() => $mockService);
    }

    /**
     * @dataProvider requestWithMissingFieldsProvider
     */
    public function
    test_validation_fails_when_missing_fields(array $request)
    {
        $response = $this->post('/users', $request);
        $response->assertStatus(400);
    }

    public function requestWithMissingFieldsProvider(): Generator
    {
        foreach (['username', 'password', 'about'] as $f) {
            yield [[$f => $f]];
        }

        yield from [
            [['username' => 'username', 'password' => 'password']],
            [['username' => 'username', 'about' => 'about']],
            [['password' => 'password', 'about' => 'about']],
        ];
    }
}
