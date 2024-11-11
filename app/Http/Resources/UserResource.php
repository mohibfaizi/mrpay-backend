<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $token =  $this->createToken('token-name', ['*'], Carbon::now()->addHours(4));
        // generating token and extract the plaintext token and expires_at time 
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image,
            'role' => $this->role,
            'token' => $token->plainTextToken,
            'expires_at' => $token->accessToken->expires_at ? $token->accessToken->expires_at->toDateTimeString() : null,
          
        ];
    }
}
