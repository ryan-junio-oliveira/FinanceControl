<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Organization\Presentation\Http\Controllers\OrganizationController;

Route::middleware(['web','auth','force_password_change','role:gestor|root'])->group(function () {
    // list view (already existed)
    Route::get('/organization/list', [OrganizationController::class, 'index'])->name('organization.list');

    // settings / members management
    Route::get('/organization', [OrganizationController::class, 'edit'])->name('organization.edit');
    Route::put('/organization', [OrganizationController::class, 'update'])->name('organization.update');
    Route::post('/organization/invite', [OrganizationController::class, 'inviteMember'])->name('organization.invite');
    Route::delete('/organization/members/{user}', [OrganizationController::class, 'removeMember'])->name('organization.members.remove');
    Route::post('/organization/archive', [OrganizationController::class, 'archive'])->name('organization.archive');
    Route::post('/organization/unarchive', [OrganizationController::class, 'unarchive'])->name('organization.unarchive');
    Route::delete('/organization', [OrganizationController::class, 'destroy'])->name('organization.destroy');
});
