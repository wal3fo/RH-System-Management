<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth;

use App\Models\Functions;

Route::get('/', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('welcome');
});

Route::get('sessions/signin', function () {
    if(Functions::IsConnected()) {
        return redirect('/');
    }
    return view('sessions.signin');
});

Route::get('sessions/settings', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('sessions.settings');
});

Route::get('sessions/rules', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('sessions.rules');
});

Route::get('manager/users/directors', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.users.directors');
});

Route::get('manager/users/functions', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.users.functions');
});

Route::get('manager/users/managers', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.users.managers');
});

Route::get('manager/users/salaries', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.users.salaries');
});

Route::get('manager/users/dropped', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.users.dropped');
});

Route::get('sessions/certificates', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.certificates.session');
});

Route::get('teams/certificates', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.certificates.teams');
});

Route::get('sessions/vacations', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.vacations.session');
});

Route::get('teams/vacations', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.vacations.teams');
});

Route::get('sessions/absences', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.absences.session');
});

Route::get('teams/absences', function () {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.absences.teams');
});

Route::get('vacations/certificates/{ReferenceId}', function ($ReferenceId) {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('sessions.certificates.vacations', ['ReferenceId' => $ReferenceId]);
});

Route::get('absences/certificates/{ReferenceId}', function ($ReferenceId) {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('sessions.certificates.absences', ['ReferenceId' => $ReferenceId]);
});

Route::get('manager/users/{UserId}-{UserName}', function ($UserId) {
    if(!Functions::IsConnected()) {
        return redirect('sessions/signin');
    }
    return view('manager.users.viewer', ['UserId' => $UserId]);
});


Route::post('handleRequestCreateV', [Auth::class, 'handleRequestCreateV']);
Route::post('handleRequestUpdateV', [Auth::class, 'handleRequestUpdateV']);

Route::post('handleRequestCreateA', [Auth::class, 'handleRequestCreateA']);
Route::post('handleRequestUpdateA', [Auth::class, 'handleRequestUpdateA']);

Route::post('handleRequestCreateC', [Auth::class, 'handleRequestCreateC']);
Route::post('handleRequestUpdateC', [Auth::class, 'handleRequestUpdateC']);

Route::post('handleRequestUpdate', [Auth::class, 'handleRequestUpdate']);

Route::post('handleLinkUsers', [Auth::class, 'handleLinkUsers']);
Route::post('handleUnlinkUsers', [Auth::class, 'handleUnlinkUsers']);

Route::post('handleUserUpdate', [Auth::class, 'handleUserUpdate']);
Route::post('handleUserSignIn', [Auth::class, 'handleUserSignIn']);
Route::post('handleUserSignUp', [Auth::class, 'handleUserSignUp']);
Route::post('handleUserUpdate', [Auth::class, 'handleUserUpdate']);
Route::post('handleUserDelete', [Auth::class, 'handleUserDelete']);
Route::post('handleUserRestore', [Auth::class, 'handleUserRestore']);
Route::post('handleUserSignOut', [Auth::class, 'handleUserSignOut']);

Route::post('handleUserAvatarUpdate', [Auth::class, 'handleUserAvatarUpdate']);

Route::post('handleHolidaysUpdate', [Auth::class, 'handleHolidaysUpdate']);

Route::post('handleFunctionCreate', [Auth::class, 'handleFunctionCreate']);
Route::post('handleFunctionUpdate', [Auth::class, 'handleFunctionUpdate']);
Route::post('handleFunctionRemove', [Auth::class, 'handleFunctionRemove']);
