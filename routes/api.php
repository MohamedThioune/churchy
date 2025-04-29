<?php
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/login',  function (Request $request) {
    return response()->json(['message' => 'Unauthenticated.'], 401);
})->name('failed');

Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])->name('passport.token');
Route::post('/register', [App\Http\Controllers\API\AuthAPIController::class, 'register'])->name('auth.register');
// Route::post('/login', [App\Http\Controllers\API\AuthAPIController::class, 'login'])->name('auth.login');
Route::middleware('auth:api')->post('/logout', [App\Http\Controllers\API\AuthAPIController::class, 'logout'])->name('auth.logout');;
Route::middleware('auth:api')->get('/user', [App\Http\Controllers\API\AuthAPIController::class, 'user'])->name('auth.user');;

Route::post('/upload', [App\Http\Controllers\API\FileAPIController::class, 'upload'])->name('file.upload');

Route::resource('files', App\Http\Controllers\API\FileAPIController::class)
    ->except(['create', 'edit']);

Route::resource('expenses', App\Http\Controllers\API\ExpenseAPIController::class)
    ->except(['create', 'edit']);

Route::resource('deposits', App\Http\Controllers\API\DepositAPIController::class)
    ->except(['create', 'edit']);

Route::resource('demands', App\Http\Controllers\API\DemandAPIController::class)
    ->except(['create', 'edit']);

Route::resource('workships', App\Http\Controllers\API\WorkshipAPIController::class)
    ->except(['create', 'edit']);

Route::resource('tithes', App\Http\Controllers\API\TitheAPIController::class)
    ->except(['create', 'edit']);

Route::resource('payments', App\Http\Controllers\API\PaymentAPIController::class)
    ->except(['create', 'edit']);

Route::resource('sacraments', App\Http\Controllers\API\SacramentAPIController::class)
    ->except(['create', 'edit']);

Route::resource('don-legs', App\Http\Controllers\API\DonLegAPIController::class)
    ->except(['create', 'edit']);