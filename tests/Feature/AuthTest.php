<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLoginGagal(): void
    {
        $this->post("/login", data: [
            "email" => "tidak@gmail.com",
            "password" => Hash::make("salah")
        ])->assertSeeText("Login");
    }
}
