<?php

use App\Tools\DeveloperTest;
use Illuminate\Support\Facades\Route;

//question number 1


Route::get('/question-1', function () {
    DeveloperTest::logData('This is a test', ['code' => 1234, 'user_id' => 'abcd123']);
})->name('question.one');