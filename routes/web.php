<?php

use App\Http\Controllers\FamilyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[FamilyController::class,'index'])->name('family.list.view');
Route::get('/add-family-head',[FamilyController::class,'addFamilyHead'])->name('family.head.add');
Route::post('/save-family-head',[FamilyController::class,'saveFamilyHead'])->name('family.head.save');
Route::get('/add-family-member',[FamilyController::class,'addFamilyMember'])->name('family.member.add');
Route::post('/save-family-member',[FamilyController::class,'saveFamilyMember'])->name('family.member.save');
Route::get('/family-members',[FamilyController::class,'memberLists'])->name('family.member.list');



