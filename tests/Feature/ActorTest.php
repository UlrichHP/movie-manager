<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('can get all actors list', function () {
    get('api/actors')
        ->assertOk()
        ->assertJsonCount(2)
        ->assertJson(function (AssertableJson $json) {
            $json->has('success')
                ->whereType('success', 'boolean')
                ->has('data')
                ->whereType('data', 'array')
                ->where('data.total', 10)
                ->has('data.data.0')
                ->has('data.data.0.id')
                ->has('data.data.0.name')
                ->has('data.data.0.birthday')
                ->has('data.data.0.nationality')
                ->has('data.data.0.created_at')
                ->has('data.data.0.updated_at')
                ->has('data.data.0.user_id')
                ->whereType('data.data.0.id', 'integer')
                ->whereType('data.data.0.name', 'string')
                ->whereType('data.data.0.birthday', 'string')
                ->whereType('data.data.0.nationality', 'string')
                ->whereType('data.data.0.created_at', 'string')
                ->whereType('data.data.0.updated_at', 'string')
                ->whereType('data.data.0.user_id', 'integer');
        });
});

it('can show one actor', function () {
    get('api/actors/1/show')
        ->assertOk()
        ->assertJsonCount(2)
        ->assertJson(function (AssertableJson $json) {
            $json->has('success')
                ->whereType('success', 'boolean')
                ->has('data')
                ->whereType('data', 'array')
                ->count('data', 7)
                ->has('data.id')
                ->has('data.name')
                ->has('data.birthday')
                ->has('data.nationality')
                ->has('data.created_at')
                ->has('data.updated_at')
                ->has('data.user_id')
                ->whereType('data.id', 'integer')
                ->whereType('data.name', 'string')
                ->whereType('data.birthday', 'string')
                ->whereType('data.nationality', 'string')
                ->whereType('data.created_at', 'string')
                ->whereType('data.updated_at', 'string')
                ->whereType('data.user_id', 'integer');
        });
});

it('can\'t create an actor if anonymous', function () {
    $actor = [
        'name' => 'Jane Fonda',
        'birthday' => '1975-01-29',
        'nationality' => 'American',
    ];

    post('/api/actors/create', $actor)
        ->assertFound()
        ->assertRedirect('/api/login');
});

it('can create an actor if logged in', function () {
    $actor = [
        'name' => 'Jane Fonda',
        'birthday' => '1975-01-29',
        'nationality' => 'American',
    ];

    $user = [
        'name' => 'John Doe',
        'email' => 'johndoe@gmail.com',
        'password' => 'password',
    ];

    User::create($user);

    $data = post('/api/login', $user);

    post('/api/actors/create', $actor, [
        'Authorization' => 'Bearer '.$data['token'],
    ])
        ->assertOk()
        ->assertJsonCount(3)
        ->assertJson(function (AssertableJson $json) {
            $json->has('success')
                ->whereType('success', 'boolean')
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', trans('Actor has been created'))
                ->has('data')
                ->whereType('data', 'array')
                ->count('data', 7)
                ->has('data.id')
                ->has('data.name')
                ->has('data.birthday')
                ->has('data.nationality')
                ->has('data.created_at')
                ->has('data.updated_at')
                ->has('data.user_id')
                ->whereType('data.id', 'integer')
                ->whereType('data.name', 'string')
                ->whereType('data.birthday', 'string')
                ->whereType('data.nationality', 'string')
                ->whereType('data.created_at', 'string')
                ->whereType('data.updated_at', 'string')
                ->whereType('data.user_id', 'integer');
        });
});

it('can\'t update an actor if anonymous', function () {
    put('/api/actors/1/edit', [])
        ->assertFound()
        ->assertRedirect('/api/login');
});

it('can\'t delete an actor if anonymous', function () {
    delete('/api/actors/1/delete', [])
        ->assertFound()
        ->assertRedirect('/api/login');
});
