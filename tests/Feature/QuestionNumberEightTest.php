<?php


use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;



test('allows access for users with the correct role and within allowed time', function () {
    // Create a user with the required role
    $user = User::factory()->canEditArticle()->create();
    
    // Mock the current time to be within 9 AM and 5 PM
    $this->travelTo(now()->setHour(11));

    // Act as the user and make a request
    $response = $this->actingAs($user)->get(route('question.eight'));

    // Assert that access is granted
    $response->assertStatus(200);
});

test('denies access for users without the correct role', function () {
    // Create a user without the required role
    $user = User::factory()->create();

    // Mock the current time to be within 9 AM and 5 PM
    $this->travelTo(now()->setHour(10));

    // Act as the user and make a request
    $response = $this->actingAs($user)->get(route('question.eight'));

    // Assert that access is denied
    $response->assertStatus(403)
        ->assertJson(['error' => 'Forbidden: You do not have the required role']);
});

test('denies access outside allowed time', function () {
    // Create a user with the required role
    $user = User::factory()->canEditArticle()->create();
    

    // Mock the current time to be outside 9 AM and 5 PM
    $this->travelTo(now()->setHour(18));

    // Act as the user and make a request
    $response = $this->actingAs($user)->get(route('question.eight'));

    // Assert that access is denied
    $response->assertStatus(403)
        ->assertJson(['error' => 'Access denied: Available only between 9 AM and 5 PM']);
});

test('tracks the number of requests from the user', function () {
    // Create a user with the required role
    $user = User::factory()->canEditArticle()->create();
  

    // Mock the current time to be within 9 AM and 5 PM
    $this->travelTo(now()->setHour(10));

    // Act as the user and make a request
    $this->actingAs($user)->get(route('question.eight'));

    // Assert that the request count is tracked
    $requestCount = $user->refresh()->request_count;
    expect($requestCount)->toBe(1);
});