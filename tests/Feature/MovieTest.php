<?php

use Database\Seeders\DatabaseSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('can get all movies list', function () {
    get('api/movies')
        ->assertOk()
        ->assertJsonCount(2)
        ->assertJson(function (AssertableJson $json) {
            $json->has('success')
                ->whereType('success', 'boolean')
                ->has('data')
                ->whereType('data', 'array')
                ->where('data.total', 20)
                ->has('data.data.0')
                ->has('data.data.0.id')
                ->has('data.data.0.title')
                ->has('data.data.0.description')
                ->has('data.data.0.year')
                ->has('data.data.0.duration')
                ->has('data.data.0.created_at')
                ->has('data.data.0.updated_at')
                ->whereType('data.data.0.id', 'integer')
                ->whereType('data.data.0.title', 'string')
                ->whereType('data.data.0.description', 'string')
                ->whereType('data.data.0.year', 'integer')
                ->whereType('data.data.0.duration', 'string')
                ->whereType('data.data.0.created_at', 'string')
                ->whereType('data.data.0.updated_at', 'string');
        });
});

it('can show one movie', function () {
    get('api/movies/1/show')
        ->assertOk()
        ->assertJsonCount(2)
        ->assertJson(function (AssertableJson $json) {
            $json->has('success')
                ->whereType('success', 'boolean')
                ->has('data')
                ->whereType('data', 'array')
                ->count('data', 10)
                ->has('data.id')
                ->has('data.title')
                ->has('data.description')
                ->has('data.year')
                ->has('data.duration')
                ->has('data.created_at')
                ->has('data.updated_at')
                ->whereType('data.id', 'integer')
                ->whereType('data.title', 'string')
                ->whereType('data.description', 'string')
                ->whereType('data.year', 'integer')
                ->whereType('data.duration', 'string')
                ->whereType('data.created_at', 'string')
                ->whereType('data.updated_at', 'string');
        });
});

it('can\'t create a movie if anonymous', function () {
    post('/api/movies/create', [])
        ->assertFound()
        ->assertRedirect('/api/login');
});

it('can\'t update a movie if anonymous', function () {
    put('/api/movies/1/edit', [])
        ->assertFound()
        ->assertRedirect('/api/login');
});

it('can\'t delete a movie if anonymous', function () {
    delete('/api/movies/1/delete', [])
        ->assertFound()
        ->assertRedirect('/api/login');
});
