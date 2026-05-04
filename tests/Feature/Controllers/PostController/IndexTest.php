<?php

use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


it('should return the correct component', function () {
    $posts = Post::factory(3)->create();



    get(route('posts.index'))
        ->assertHasComponent('Posts/Index');
});

it('passes posts to the view', function () {

    $posts = Post::factory(3)->create();

    $posts->load('user');

    get(route('posts.index'))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
});
