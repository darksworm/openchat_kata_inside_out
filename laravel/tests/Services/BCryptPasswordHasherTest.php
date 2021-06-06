<?php

namespace Tests\Services;

use App\Exceptions\CannotHashEmptyPasswordException;
use App\Services\BCryptPasswordHasher;
use App\Services\PasswordHasher;
use Tests\TestCase;

class BCryptPasswordHasherTest extends TestCase
{
    private BCryptPasswordHasher $hasher;

    protected function setUp(): void
    {
        $this->hasher = new BCryptPasswordHasher();
        parent::setUp();
    }

    public function
    test_is_instance_of_PasswordHasher()
    {
        $this->assertInstanceOf(PasswordHasher::class, $this->hasher);
    }

    public function
    test_hashForPassword_does_not_return_plain_password()
    {
        $hashed = $this->hasher->hashForPassword("password");

        $this->assertNotEquals("password", $hashed);
    }

    public function
    test_hashForPassword_does_not_return_same_hash_for_same_password()
    {
        $first = $this->hasher->hashForPassword("password");
        $second = $this->hasher->hashForPassword("password");

        $this->assertNotEquals($first, $second);
    }

    public function
    test_hashForPassword_throws_when_empty_password_provided()
    {
        $this->expectException(CannotHashEmptyPasswordException::class);
        $this->hasher->hashForPassword("");
    }

    public function
    test_hashForPassword_produces_hash_which_matches_password()
    {
        $hashed = $this->hasher->hashForPassword("password");
        $result = $this->hasher->passwordMatchesHash("password", $hashed);

        $this->assertTrue($result, "generated hash should match provided password");
    }

    public function
    test_passwordMatchesHash_returns_false_when_passed_random_strings()
    {
        $this->assertFalse($this->hasher->passwordMatchesHash("random", "stuff"));
    }

    public function
    test_passwordMatchesHash_returns_false_with_incorrect_password()
    {
        $hashed = $this->hasher->hashForPassword("password");
        $result = $this->hasher->passwordMatchesHash("nottoday", $hashed);

        $this->assertFalse($result);
    }
}
