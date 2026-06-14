<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing');
});

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

Route::get('/forgot-password', function () {
    return Inertia::render('Auth/Login');
})->name('password.request');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/Index');
})->name('dashboard');

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

Route::get('/access/create', fn () => Inertia::render('Access/Create'));

Route::get('/reminders', function () {
    return Inertia::render('Reminders/Index');
});

Route::get('/time-capsule', function () {
    return Inertia::render('TimeCapsule/Index');
})->name('time-capsule.index');

Route::get('/time-capsule/create', function () {
    return Inertia::render('TimeCapsule/Create');
})->name('time-capsule.create');

Route::get('/time-capsule/{id}', function ($id) {
    return Inertia::render('TimeCapsule/Show', [
        'id' => $id
    ]);
})->name('time-capsule.show');

Route::get('/inheritance', function () {
    return Inertia::render('Inheritance/Index');
})->name('inheritance.index');

Route::get('/notary', function () {
    return Inertia::render('Notary/Index');
})->name('notary.index');

Route::get('/claims', function () {
    return Inertia::render('Claims/Index');
})->name('claims.index');