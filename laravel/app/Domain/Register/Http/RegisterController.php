<?php


namespace App\Domain\Register\Http;

use App\Domain\Register\DuplicateUsernameException;
use App\Domain\Register\RegisterService;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    private RegisterService $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    public function registerUser(RegisterRequest $request): Response
    {
        try {
            $user = $this->service->register(
                $request->getUsername(),
                $request->getPassword(),
                $request->getAbout()
            );
        } catch (DuplicateUsernameException) {
            return response("Username already in use", 400);
        }

        $transformedUser = UserTransformer::transform($user);

        return response($transformedUser, 201);
    }
}
