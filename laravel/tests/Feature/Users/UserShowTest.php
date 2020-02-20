<?php

namespace Tests\Feature\Users;

use App\User;
use Tests\Feature\Core\AuthenticatedTestCase;

class UserShowTest extends AuthenticatedTestCase
{
    public function test_cannot_access_if_not_authenticated()
    {
        $response = $this->get("/api/users/1");
        $response->assertUnauthorized();
    }

    public function test_show_404_if_does_not_exist()
    {
        $this->authenticate();
        // from a fresh database this user id should not exist
        $response = $this->get("/api/users/19232");
        $response->assertNotFound();
    }

    public function test_show_user_details()
    {
        $this->authenticate();
        factory(User::class)->create([
            'id' => 9999,
            'name' => 'Donaldo Trumpo',
            'email' => 'el_donaldo@trumpo.gov'
        ]);
        $response = $this->get("/api/users/9999");

        $this->assertequals('user', $response->json('data.type'));
        $this->assertequals("Donaldo Trumpo", $response->json('data.attributes.name'));
        $this->assertequals("el_donaldo@trumpo.gov", $response->json('data.attributes.email'));
    }
}
