<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\post;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('can register an user', function () {
    $newUser = [
        'name' => 'John Doe',
        'email' => 'johndoe@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    post(route('api.register'), $newUser)
        ->assertCreated()
        ->assertJsonCount(3)
        ->assertJson(function (AssertableJson $json) {
            $json->has('success')
                ->whereType('success', 'boolean')
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', trans('User created'))
                ->has('user')
                ->whereType('user', 'array')
                ->count('user', 6)
                ->has('user.id')
                ->has('user.name')
                ->has('user.email')
                ->has('user.created_at')
                ->has('user.updated_at')
                ->has('user.roles')
                ->whereType('user.id', 'integer')
                ->whereType('user.name', 'string')
                ->whereType('user.email', 'string')
                ->whereType('user.created_at', 'string')
                ->whereType('user.updated_at', 'string')
                ->whereType('user.roles', 'array')
                ->where('user.name', 'John Doe')
                ->where('user.email', 'johndoe@gmail.com');
        });
});

it('can log in an user', function () {
    $user = [
        'name' => 'John Doe',
        'email' => 'johndoe@gmail.com',
        'password' => 'password',
    ];

    User::create($user);

    post(route('api.login'), $user)
        ->assertOk()
        ->assertJsonCount(3)
        ->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->whereType('message', 'string')
                ->where('message', trans('User logged in'))
                ->has('user')
                ->whereType('user', 'array')
                ->count('user', 6)
                ->has('user.id')
                ->has('user.name')
                ->has('user.email')
                ->has('user.created_at')
                ->has('user.updated_at')
                ->has('user.email_verified_at')
                ->whereType('user.id', 'integer')
                ->whereType('user.name', 'string')
                ->whereType('user.email', 'string')
                ->whereType('user.created_at', 'string')
                ->whereType('user.updated_at', 'string')
                ->whereType('user.email_verified_at', 'null|string')
                ->where('user.email', 'johndoe@gmail.com')
                ->has('token')
                ->whereType('token', 'string');
        });
});

it('can\'t log in an user with bad credentials', function () {
    $user = [
        'name' => 'John Doe',
        'email' => 'johndoe@gmail.com',
        'password' => 'password',
    ];

    User::create($user);

    post(route('api.login'), [
        'email' => 'johndoe@gmail.com',
        'password' => 'password2',
    ])
        ->assertForbidden()
        ->assertJsonCount(1)
        ->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->whereType('message', 'string')
                ->where('message', trans('Invalid credentials'));
        });
});
