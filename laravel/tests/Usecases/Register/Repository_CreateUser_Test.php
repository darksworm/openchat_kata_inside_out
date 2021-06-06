<?php

namespace Tests\Usecases\Register;

use App\Usecases\Register\DuplicateUsernameException;
use App\Usecases\Register\UserRegistrationRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Repository_CreateUser_Test extends TestCase
{
    private UserRegistrationRepository $repo;
    private UserRegistrationRepository $otherRepo;

    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();

        $this->repo = new UserRegistrationRepository();
        $this->otherRepo = new UserRegistrationRepository();
    }

    public function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }

    public function
    test_repository_starts_out_empty()
    {
        $this->assertEquals(0, $this->repo->getUserCount());
    }

    public function
    test_user_count_is_one_after_creating_one_user_on_different_instances()
    {
        $this->repo->createUser("username", "password", "about");
        $this->assertEquals(1, $this->otherRepo->getUserCount());
    }

    public function
    test_creating_user_with_same_username_across_different_instances_not_allowed()
    {
        $this->expectException(DuplicateUsernameException::class);

        $this->repo->createUser("username", "password", "about");
        $this->otherRepo->createUser("username", "password", "about");
    }

    public function
    test_created_user_matches_provided_fields()
    {
        $user = $this->repo->createUser("username", "password", "about");

        $this->assertEquals("username", $user->username);
        $this->assertEquals("password", $user->password);
        $this->assertEquals("about", $user->about);
    }

    public function
    test_users_are_created_with_distinct_ids()
    {
        $user = $this->repo->createUser("1", "2", "3");
        $otherUser = $this->repo->createUser("9", "8", "7");

        $this->assertNotEquals($user->user_id, $otherUser->user_id);
    }

    public function
    test_created_ids_are_uuids()
    {
        $user = $this->repo->createUser("1", "2", "3");

        $this->assertValidUUID($user->user_id);
    }
}
