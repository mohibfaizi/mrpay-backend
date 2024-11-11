<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function __construct(private UserServices $userServices) {}

    public function signinWithGoogle(Request $request)
    {
        $data = $request->validate([
            'id_token' => ['required', 'string'],
            'provider' => ['required', 'string']
        ]);
        $response = Http::get("https://oauth2.googleapis.com/tokeninfo", [
            'id_token' => $data['id_token'],
        ]);

        if ($response->failed() || $response->json('aud') !== config('services.google.client_id')) {
            return response()->json(['error' => 'Invalid Google ID token'], 401);
        } else {
            $email =  $response->json()['email'];
            $name =  $response->json()['given_name'];
            $last_name =  $response->json()['family_name'];
            $user =  $this->userServices->findByColumnName('email', $email);
            if ($user == null) {
                $user = $this->userServices->create([
                    'name' => $name .' '.$last_name,
                  
                    'email' => $email,
                ]);
              
            }
            return $this->generateAccessToken($user);
        }
    }
    public function signin(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string'],
            'auth_method' => ['required', 'in:email,phone,google']
        ]);

        // Only handle 'email' and 'phone' auth methods; add specific handling for 'google' if needed
        if (in_array($data['auth_method'], ['email', 'phone'])) {
            $user = $this->getUserOrCreateByPhone($data['phone']);
            return $this->generateAccessToken($user);
        }

        return response()->json(['error' => 'Unsupported authentication method'], 400);
    }

    /**
     * Retrieve or create a user by phone number
     *
     * @param string $phone
     * @return User
     */
    private function getUserOrCreateByPhone(string $phone): User
    {
        return $this->userServices->findByColumnName('phone', $phone)
            ?? $this->userServices->create(['phone' => $phone]);
    }

    /**
     * Generate and return the access token response
     *
     * @param User $user
     * @return UserResource
     */
    private function generateAccessToken(User $user): UserResource
    {
        return new UserResource($user);
    }
}
