<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    /**
     * Test getting user and verify the data type is correct.
     *
     * @return void
     */
    public function testDataType()
    {
        $user = User::inRandomOrder()->first();
        $this -> assertInternalType('int',$user->id);
        $this -> assertInternalType('string', $user -> name);
        $this -> assertInternalType('string', $user -> email);
        $this -> assertInstanceOf('App\User',$user);
    }


    /**
     * Test for creating a user and verify that user information is correct.
     */
    public function testCreateUser()
    {
        $rand = rand(1,999999);
        $data = [
            'name' => 'name'.$rand,
            'email' => 'email'.$rand.'@gmail.com',
            'password' => 'password'
        ];

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $this->assertTrue(true);

        $user = User::where('name',$data['name']) -> first();
        $this -> assertEquals($data['email'],$user->email);
        $this -> assertEquals($data['password'],$user->password);

    }

    /**
     * Test for updating a user record and verify that user record is updated correctly
     */
    public function testUpdateUser()
    {
        // grab test user data
        $user = User::where('email', 'validuser@gmail.com') -> first();
        $oldName = $user -> name;
        $newName = 'name'.rand(1,999999);
        // update user name
        User::where('email', 'validuser@gmail.com') -> update(['name' => $newName]);
        // verify name is different
        $user = User::where('email', 'validuser@gmail.com') -> first();
        $this -> assertSame($user -> name, $newName);
        $this -> assertFalse($oldName == $user -> name);
    }


    /**
     * Test email format
     */
    public function testEmailFormat()
    {
        $user = User::inRandomOrder() -> first();
        // email should not be empty
        $this -> assertNotNull($user -> email);
        // email should at least contain a @ symbol
        $this -> assertContains('@', $user -> email);
    }

    /**
     * Test delete a user
     */
    public function testDeleteUser()
    {
        $rand = rand(1,999999);
        $data = [
            'name' => 'name'.$rand,
            'email' => 'email'.$rand.'@gmail.com',
            'password' => 'password'
        ];

        // create a new user
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $this->assertTrue(true);
        // delete this user
        $user = User::where('name',$data['name']) -> first() -> delete();
        // try to get user again
        $user = User:: where('name', $data['name']) -> first();
        $this -> assertNull($user);
    }
}
