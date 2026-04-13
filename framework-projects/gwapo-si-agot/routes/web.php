<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('gay', [
        'gay'=>['kent','agot','si agot']
    ]);
});

Route::get('/notes', function() {
    $lol = session()->get('notes',[]);
    return view('notes', [
        'lol' => $lol
    ]);
});

Route::post('/notes', function () {
    $lol = request('note');
    session()->push('notes',$lol);
    return redirect('/notes');
});

Route::get('/profile', function() {
    $profile = session()->get('profile',[]);
    return view('profile', [
        'profile' => $profile
    ]);
});

Route::post('/profile', function () {
    $profile = request(['name', 'age', 'program','email', 'gender', 'hobbies', 'bio']);

    session()->push('profile', $profile);
    return redirect('profile');
});

Route::delete('/delete-profile', function () {
    session()->forget('profile');
    return redirect('profile');
});