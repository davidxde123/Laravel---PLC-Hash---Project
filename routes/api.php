<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


{
    "name": "MARCELA",
    "email": "MARCELA@gmail.com",
    "password": "123456",
    "password_confirmation": "123456"
}

*/




    /*
    Header cuando es POST:
    Content-Type application/json
    X-Requested-With: XMLHttpRequest
    */ 


/* Inicio de sesion */


//POST plc_mx.devel.com/api/auth/signup
//POST plc_mx.devel.com/api/auth/login

//GET plc_mx.devel.com/api/auth/logout
//GET plc_mx.devel.com/api/auth/user


//POST plc_mx.devel.com/api/password/create
//GET http://plc_mx.devel.com/api/password/find/{id}
//POST http://plc_mx.devel.com/api/password/reset


//GET http://plc_mx.devel.com/api/roles
//POST http://plc_mx.devel.com/api/roles/store
//PUT http://plc_mx.devel.com/api/roles/{id}
//GET http://plc_mx.devel.com/api/roles/{id}

Route::group([
    'prefix' => 'auth'

], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


/* Cambio de contraseña */

Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});




/* Creacion de roles: Admin -Solamente (Por defecto) */

Route::group([
   
 'middleware' =>  ['auth:api', 'role:Admin']
],function(){

Route::resources([
    'roles'    => 'RoleController',
    'user'     =>  'UserController',
    'permisos' => 'PermissionController'
]);


});








