<?php

use App\Models\Comment;
use function Pest\Laravel\put;
use function Pest\Laravel\actingAs;
use App\Models\User;


it('requires authentication', function () {
    put(route('comments.update',Comment::factory()->create()))
    ->assertRedirect(route('login'));
});

it('can update a comment', function () {
    $comment = Comment::factory()->create(['body' => 'Old body']);
    $newBody = 'New body';


    actingAs($comment->user)
        ->put(route('comments.update', $comment), [
            'body' => $newBody,
        ]);

    $this->assertDatabaseHas(Comment::class, [
        'id' => $comment->id,
        'body' => $newBody,
    ]);

});

it('redirects to the post show page', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', $comment), [
            'body' => 'New body',
        ])
        ->assertRedirect(route('posts.show', $comment->post));
});

it('redirects to the correct page of comments', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', ['comment' => $comment, 'page' => 2]), [
            'body' => 'New body',
        ])
        ->assertRedirect(route('posts.show', ['post' => $comment->post, 'page' => 2]));
});

it('cannot update a comment from another user', function () {
    $comment = Comment::factory()->create();

    actingAs(User::factory()->create())
        ->put(route('comments.update', $comment), [
            'body' => 'New body',
        ])
        ->assertForbidden();
});

it('requires a valid body', function ($value) {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', $comment), [
            'body' => $value,
        ])
        ->assertInvalid('body');
})->with([
    null,
    1,
    1.5,
    true,
    str_repeat('a', 2501),
]);