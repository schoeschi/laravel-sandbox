<?php

use App\Models\Bike;
use Illuminate\Support\Facades\Route;

Route::prefix('responder')->group(function () {
    Route::get('/hi', function () {
        return "Hallo Welt";
    });

    Route::get('/number', function () {
        return random_int(1, 10);
    });

    Route::get('/www', function () {
        return redirect("https://www.ict-bz.ch");
    });

    Route::get('/favi', function () {
        return Response::download('favicon.ico');
    });

    Route::get('/hi/{name}', function (string $name) {
        return "Hallo " . $name;
    });

    Route::get('/weather', function () {
        return [
            'city' => 'Luzern',
            'temperature' => 20,
            'wind' => 10,
            'rain' => 0,
        ];
    });

    Route::get('/error', function () {
        return response()->json(['error' => 'Nicht autorisiert!'], 401);
    });

    Route::get('/multiply/{number1}/{number2}', function (int $number1, int $number2) {
        return $number1 * $number2;
    })->whereNumber("number1")->whereNumber("number2");
});
Route::prefix('hallo-velo')->group(function () {
    Route::get('/bikes', function () {
        $pdo = new PDO('sqlite:' . database_path('database.sqlite'));
        $query = $pdo->prepare('SELECT * FROM bikes');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    });

    Route::get('/bikes/{id}', function (int $id) {
        $pdo = new PDO('sqlite:' . database_path('database.sqlite'));
        $query = $pdo->prepare('SELECT * FROM bikes WHERE id = :id');
        $query->bindParam('id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    });
});
Route::get('eloquent', fn() => Bike::all());
