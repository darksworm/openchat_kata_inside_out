<?php

namespace Tests\Domain\Register\Http;

use Tests\DBTestCase;

class Register_Feature_Test extends DBTestCase
{
    public function
    test_returns_http_201_on_successful_registration()
    {
        $response = $this->postRequest(username: 'same');
        $response->assertStatus(201);
    }

    public function
    test_registering_same_username_twice_returns_400_and_message()
    {
        $this->postRequest(username: 'same');

        $response = $this->postRequest(username: 'same');
        $response->assertStatus(400);
        $response->assertSeeText('Username already in use');
    }

    public function
    test_returned_user_does_not_contain_password_field()
    {
        $response = $this->postRequest();
        $this->assertNull($response->json('password'));
    }

    public function
    test_returns_UUID_in_id_field()
    {
        $response = $this->postRequest();
        $this->assertValidUUID($response->json('id'));
    }

    public function
    test_returns_username_same_as_in_request()
    {
        $response = $this->postRequest(username: 'specific');
        $this->assertEquals('specific', $response->json('username'));
    }

    public function
    test_two_registered_users_get_distinct_UUIDS()
    {
        $firstResponse = $this->postRequest(username: 'first_user');
        $secondResponse = $this->postRequest(username: 'second_user');
        $this->assertNotEquals($firstResponse->json('id'), $secondResponse->json('id'));
    }

    private function postRequest(string $username = 'username', string $password = 'password', string $about = 'about')
    {
        return $this->post('/users', [
            'username' => $username,
            'password' => $password,
            'about' => $about
        ]);
    }
}
