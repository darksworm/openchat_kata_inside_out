<?php

namespace App\Framework\Providers;

use App\Repositories\FollowingsRepository;
use App\Repositories\IFollowingsRepository;
use App\Repositories\IPostRepository;
use App\Repositories\IUserRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Services\FollowingsService;
use App\Services\IPasswordHashService;
use App\Services\PostCreationService;
use App\Services\RegistrationService;
use App\Services\SHA512PasswordHashService;
use App\Services\PostTimelineService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
    ];
}
