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

it('can get all genres list', function () {
    get('api/genres')
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
                ->has('data.data.0.created_at')
                ->has('data.data.0.updated_at')
                ->has('data.data.0.user_id')
                ->whereType('data.data.0.id', 'integer')
                ->whereType('data.data.0.name', 'string')
                ->whereType('data.data.0.created_at', 'string')
                ->whereType('data.data.0.updated_at', 'string')
                ->whereType('data.data.0.user_id', 'integer');
        });
});

it('can show one genre', function () {
    get('api/genres/1/show')
        ->assertOk()
        ->assertJsonCount(2)
        ->assertJson(function (AssertableJson $json) {
            $json->has('success')
                ->whereType('success', 'boolean')
                ->has('data')
                ->whereType('data', 'array')
                ->count('data', 5)
                ->has('data.id')
                ->has('data.name')
                ->has('data.created_at')
                ->has('data.updated_at')
                ->has('data.user_id')
                ->whereType('data.id', 'integer')
                ->whereType('data.name', 'string')
                ->whereType('data.created_at', 'string')
                ->whereType('data.updated_at', 'string')
                ->whereType('data.user_id', 'integer');
        });
});

it('can\'t create a genre if anonymous', function () {
    $genre = [
        'name' => 'Action',
    ];

    post('/api/genres/create', $genre)
        ->assertFound()
        ->assertRedirect('/api/login');
});

it('can create a genre if logged in', function () {
    $genre = [
        'name' => 'Action',
    ];

    $user = [
        'name' => 'John Doe',
        'email' => 'johndoe@gmail.com',
        'password' => 'password',
    ];

    User::create($user);

    $data = post('/api/login', $user);

    post('/api/genres/create', $genre, [
        'Authorization' => 'Bearer '.$data['token'],
    ])
        ->assertOk()
        ->assertJsonCount(3)
        ->assertJson(function (AssertableJson $json) {
            $json->has('success')
                ->whereType('success', 'boolean')
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', trans('Genre has been created'))
                ->has('data')
                ->whereType('data', 'array')
                ->count('data', 5)
                ->has('data.id')
                ->has('data.name')
                ->has('data.created_at')
                ->has('data.updated_at')
                ->has('data.user_id')
                ->whereType('data.id', 'integer')
                ->whereType('data.name', 'string')
                ->whereType('data.created_at', 'string')
                ->whereType('data.updated_at', 'string')
                ->whereType('data.user_id', 'integer');
        });
});

it('can\'t update a genre if anonymous', function () {
    put('/api/genres/1/edit', [])
        ->assertFound()
        ->assertRedirect('/api/login');
});

it('can\'t delete a genre if anonymous', function () {
    delete('/api/genres/1/delete', [])
        ->assertFound()
        ->assertRedirect('/api/login');
});
