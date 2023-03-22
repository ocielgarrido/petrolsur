<?php
use App\Http\Controllers\User\MenuController;
use App\Http\Controllers\User\OilDetailController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\Admin\BackupController;

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::group([ "middleware" => ['auth:sanctum', 'verified'] ], function() {
    Route::view('/dashboard', "dashboard")->name('dashboard');
    
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.delete');

    Route::resource('permission', App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);

    Route::get('/areas', [MenuController::class, 'area'])->name('area');
  
    Route::get('/tank',  [MenuController::class, 'tanque'])->name('tank');
    Route::view('/tank/create', "pages.tank.create")->name('tank.create');
    Route::view('/tank/edit/{tankId}', "pages.tank.edit")->name('tank.edit');

    Route::get('/tankcontrol',  [MenuController::class, 'controltanque'])->name('tankcontrol');
    Route::view('/tankcontrol/create', "pages.tank.control.control-new")->name('tankcontrol.create');
    Route::view('/tankcontrol/edit/{tankcontrolId}', "pages.tank.control.control-edit")->name('tankcontrol.edit');


    Route::get('/well',  [MenuController::class, 'pozo'])->name('well');
    Route::view('/well/create', "pages.well.well.create")->name('well.create');
    Route::view('/well/edit/{wellId}', "pages.well.well.edit")->name('well.edit');
 
    Route::get('/welldowntime',  [MenuController::class, 'paradapozo'])->name('welldowntime');
    Route::view('/welldowntime/create', "pages.well.downtime.downtime-new")->name('welldowntime.create');
    Route::view('/welldowntime/edit/{welldowntimeId}', "pages.well.downtime.downtime-edit")->name('welldowntime.edit');

    Route::get('/wellcontrol',  [MenuController::class, 'controlpozo'])->name('wellcontrol');
    Route::view('/wellcontrol/create', "pages.well.control.control-new")->name('wellcontrol.create');
    Route::view('/wellcontrol/edit/{wellcontrolId}', "pages.well.control.control-edit")->name('wellcontrol.edit');

    Route::get('/wellintervention',  [MenuController::class, 'intervencionpozo'])->name('wellintervention');
    Route::view('/wellintervention/create', "pages.well.intervention.intervention-new")->name('wellintervention.create');
    Route::view('/wellintervention/edit/{wellinterventionId}', "pages.well.intervention.intervention-edit")->name('wellintervention.edit');

    Route::get('/variation',  [MenuController::class, 'incrementomerma'])->name('variation');
    Route::view('/variation/create', "pages.well.variation.variation-new")->name('variation.create');
    Route::view('/variation/edit/{wellvariationId}', "pages.well.variation.variation-edit")->name('variation.edit');
      
    Route::get('/compressor/downtime',  [MenuController::class, 'paradamotocompresor'])->name('downtime');
    Route::view('/compressor/downtime/create', "pages.compressor.downtime.downtime-new")->name('downtime.create');
    Route::view('/compressor/downtime/edit/{compressordowntimeId}', "pages.compressor.downtime.downtime-edit")->name('compressordowntime.edit');
     
    Route::get('/gasse',  [MenuController::class, 'gas'])->name('gasse');
    Route::view('/gasse/create', "pages.gasse.gasse-new")->name('gasse.create');
    Route::view('/gasse/edit/{gasseId}', "pages.gasse.gasse-edit")->name('gasse.edit');

    Route::get('/oil', [MenuController::class, 'mediciontanque'])->name('oil');
    Route::view('/oil/create', "pages.oil.oil-new")->name('oil.create');
    Route::view('/oil/edit/{oilId}', "pages.oil.oil-edit")->name('oil.edit');
 
    Route::get('/oilDetail', [OilDetailController::class, "index" ])->name('oildetail');
    Route::view('/oilDetail/edit/{oilId}', "pages.oil.detail.oildetail-data")->name('oildetail.edit');
 
    Route::get('/post',  [MenuController::class, 'novedad'])->name('post');
    Route::view('/post/create', "pages.post.post-new")->name('post.create');
    Route::view('/post/edit/{postId}', "pages.post.post-edit")->name('post.edit');
   
    Route::get('/movement',  [MenuController::class, 'movimiento'])->name('movement');
    Route::view('/movement/create', "pages.movement.movement-new")->name('movement.create');
    Route::view('/movement/edit/{movementId}', "pages.movement.movement-edit")->name('movement.edit');
 
    Route::get('/client',  [MenuController::class, 'cliente'])->name('client');
    Route::view('/client/create', "pages.client.client-new")->name('client.create');
    Route::view('/client/edit/{clientId}', "pages.client.client-edit")->name('client.edit');

    Route::get('/provider',  [MenuController::class, 'proveedor'])->name('provider');
    Route::view('/provider/create', "pages.provider.provider-new")->name('provider.create');
    Route::view('/provider/edit/{providerId}', "pages.provider.provider-edit")->name('provider.edit');

    Route::get('/product',  [MenuController::class, 'producto'])->name('product');
    Route::view('/product/create', "pages.product.product-new")->name('product.create');
    Route::view('/product/edit/{productId}', "pages.product.product-edit")->name('product.edit');

    Route::get('/sale',  [MenuController::class, 'venta'])->name('sale');
    Route::view('/sale/create', "pages.sale.sale-new")->name('sale.create');
    Route::view('/sale/edit/{saleId}', "pages.sale.sale-edit")->name('sale.edit');

    Route::get('/report',[ReportController::class,"index"])->name('report');
    Route::get('/report/{rptId}/{fechaFrom}/{fechaTo}/{well_id}',[ReportController::class,'ReportPDF']);

    Route::get('/backup', [BackupController::class, 'index'])->name('backups');
 
   

});
