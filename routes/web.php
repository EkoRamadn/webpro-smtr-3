<?php

use Illuminate\Support\Facades\Route;
use Pest\Support\View;

Route::redirect('/','/home');

Route::get('/home', function () {
    return view('welcome', [
        'title' => 'Home'
    ]);
});

Route::get('/projek', function () {
    return view('projek', [
        'title' => 'Projek'
    ]);
});

Route::get('/tentang', function () {
    return view('about', [
        'title' => 'Tentang',
         'nama'=> 'Eko Ramadani',
          'nim'=> 24104410087, 
          'prodi'=> "Teknik Informatika B", 
          "matakuliah"=> "Pemprograman Web Lanjut",
           'framework'=>"laravel"
    ]);
});