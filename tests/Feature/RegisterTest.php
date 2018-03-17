<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    /**
     * Test the register page is valid and accessible
     *
     * @return void
     */
    public function testRegisterPage()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }
}
