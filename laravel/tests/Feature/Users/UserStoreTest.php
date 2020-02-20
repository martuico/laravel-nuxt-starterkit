<?php

namespace Tests\Feature\Users;

use App\User;
use Tests\Feature\Core\AuthenticatedTestCase;

class UserStoreTest extends AuthenticatedTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_cannot_access_if_not_authenticated()
    {
        $response = $this->post("/api/users");
        $response->assertUnauthorized();
    }

    public function test_storing_user_requires_name_field()
    {
        $this->authenticate();
        // notice that name field is missing
        $response = $this->post("/api/users", [
            'email' => 'demo@bunkermaestro.com',
        ]);
        $response->assertJsonValidationErrors([
            'name' => 'The name field is required.'
        ]);
        $response->assertJsonMissingValidationErrors(['email']);
    }

    public function test_storing_user_requires_valid_email()
    {
        $this->authenticate();
        // notice that name field is missing
        $response = $this->post("/api/users", [
            'name' => 'John Smith',
            'email' => 'johnsmith',
        ]);
        $response->assertJsonValidationErrors([
            'email' => 'The email must be a valid email address.'
        ]);
        $response->assertJsonMissingValidationErrors(['name']);
    }

    public function test_cannot_store_without_email_field()
    {
        $this->authenticate();
        // notice that name field is missing
        $response = $this->post("/api/users", [
            'name' => 'Joe Schmoe',
        ]);
        $response->assertJsonValidationErrors([
            'email' => 'The email field is required.'
        ]);
        $response->assertJsonMissingValidationErrors(['name']);
    }

    public function test_can_store_user()
    {
        $this->authenticate();
        $response = $this->post("/api/users", [
            'name' => 'demo user',
            'email' => 'demo@bunkermaestro.com',
        ]);
        $response->assertOk();

        $this->assertequals('user', $response->json('data.type'));
        $this->assertequals("demo user", $response->json('data.attributes.name'));
        $this->assertequals("demo@bunkermaestro.com", $response->json('data.attributes.email'));
    }
}
