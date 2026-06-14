<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing');
});

Route::get('/documents', fn () => Inertia::render('Documents/Index'));
Route::get('/documents/create', fn () => Inertia::render('Documents/Create'));
Route::get('/documents/show', fn () => Inertia::render('Documents/Show'));

Route::get('/profile', function () {
    return Inertia::render('Profile/Index');
});

Route::get('/assets', function () {
    return Inertia::render('Assets/Index');
});

Route::get('/assets/create', fn () => Inertia::render('Assets/Create'));

Route::get('/access', function () {
    return Inertia::render('Access/Index');
});

Route::get('/reminders', function () {
    return Inertia::render('Reminders/Index');
});

Route::get('/time-capsule', function () {
    return Inertia::render('TimeCapsule/Index');
});