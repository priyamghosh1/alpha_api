<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AssemblyController;
use App\Http\Controllers\StateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PollingStationController;
use App\Http\Controllers\LegislativeController;
use App\Http\Controllers\PollingVolunteer;
use App\Http\Controllers\AssemblyAdminDashboard;
use App\Http\Controllers\VolunteerController;

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

//get the user if you are authenticated
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login",[UserController::class,'login']);
Route::get("login",[UserController::class,'authenticationError'])->name('login');



Route::post("register",[UserController::class,'register']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's

    Route::get("revokeAll",[UserController::class,'revoke_all']);

    Route::get('/me', function(Request $request) {
        return auth()->user();
    });
//    Route::get("/getAllAssemblies", [PersonController::class, 'getPollingVolunteerByAssembly']);
    Route::get("user",[UserController::class,'getCurrentUser']);
    Route::get("logout",[UserController::class,'logout']);

    //get all users
    Route::get("users",[UserController::class,'getAllUsers']);
    Route::post('uploadPicture',[UserController::class,'uploadPicture']);
    Route::get("getAllArea",[AreaController::class, 'get_area']);


    Route::group(array('prefix' => 'person'), function() {
        Route::get("/assembly/{id}", [PersonController::class, 'showPersonByAssembly']);
        Route::post("/", [PersonController::class, 'store']);
    });



    Route::group(array('prefix' => 'pollingAgent'), function() {
        Route::post("/", [PersonController::class, 'createPollingAgent']);
        Route::put("/", [PersonController::class, 'updatePollingAgent']);
    });

    Route::group(array('prefix' => 'legislative'), function() {
        Route::get("/{userParentId}", [LegislativeController::class, 'showVolunteersByPollingStationId']);
        Route::post("/", [LegislativeController::class, 'storeVolunteer']);
    });

//    Route::group(array('prefix' => 'assemblyConstitution'), function() {
//        Route::post("/", [PersonController::class, 'createAssemblyConstitutionByAssembly']);
//        Route::get("/{id}", [PersonController::class, 'getPollingVolunteerByAssembly']);
//    });

    Route::group(array('prefix' => 'assembly'), function() {

//        Route::get("/", [AssemblyController::class, 'index']);
        Route::get("/district/{id}", [AssemblyController::class, 'fetchAssemblyByDistrictId']);

//        Route::get("/allData", [AssemblyController::class, 'fetchAssemblyConstituenciesAlongWithDistricts']);
//        Route::get("/admin/dashboard/{assemblyId}", [AssemblyAdminDashboard::class, 'get_report']);

    });

    Route::group(array('prefix' => 'legendVolunteer'), function() {
        Route::post("/", [PersonController::class, 'createLegendVolunteerByLegislative']);
        Route::put("/", [PersonController::class, 'updateLegendVolunteerByLegislative']);
        Route::get("/{legislativeCandidate}", [PersonController::class, 'getLegendVolunteerByLegislative']);
    });

    Route::group(array('prefix' => 'districtAdmin'), function() {
        Route::post("/", [PersonController::class, 'createDistrictAdminByLegendVolunteer']);
        Route::put("/", [PersonController::class, 'updateDistrictAdminByLegendVolunteer']);
        Route::get("/{legendVolunteerId}", [PersonController::class, 'getDistrictAdminByLegendVolunteer']);
    });

    Route::group(array('prefix' => 'assemblyVolunteer'), function() {
        Route::get("/{id}", [PersonController::class, 'getAssemblyVolunteerByDistrictAdmin']);
        Route::post("/", [PersonController::class, 'createAssemblyVolunteerByDistrictAdmin']);
        Route::put("/", [PersonController::class, 'updateAssemblyVolunteerByDistrictAdmin']);
        Route::get("/{assemblyVolunteerId}/members", [AssemblyController::class, 'fetchGeneralWorkersByAssemblyVolunteerId']);
    });

    Route::group(array('prefix' => 'pollingVolunteer'), function() {
        Route::post("/", [PersonController::class, 'createPollingVolunteerByAssembly']);
        Route::put("/", [PersonController::class, 'updatePollingVolunteerByAssembly']);
        Route::get("/{id}", [PersonController::class, 'getPollingVolunteerByAssembly']);
        Route::get("/{pollingVolunteerId}/members", [PollingVolunteer::class, 'fetchGeneralWorkersByPollingVolunteerId']);
    });

    Route::group(array('prefix' => 'boothVolunteer'), function() {
        Route::post("/", [PersonController::class, 'createBoothByPollingAgent']);
        Route::put("/", [PersonController::class, 'updateBoothByPollingAgent']);
        Route::get("/{id}", [PersonController::class, 'getBoothByPollingAgent']);
        Route::get("/{boothId}/members", [PersonController::class, 'fetchGeneralWorkersByBoothId']);
        Route::get("/{boothId}/volunteer", [PersonController::class, 'fetchVolunteerByBoothId']);
    });

    Route::group(array('prefix' => 'volunteer'), function() {
        Route::post("/", [PersonController::class, 'createVolunteerByBooth']);
        Route::put("/", [PersonController::class, 'updateVolunteerByBooth']);
        Route::get("/{id}", [PersonController::class, 'getVolunteerByBoothVolunteer']);
//        Route::get("/booth/{id}", [PersonController::class, 'getVolunteerByBoothMember']);
//        Route::post("/", [PollingVolunteer::class, 'storePollingStationGeneralMember']);
        Route::get("/{volunteerId}/members", [VolunteerController::class, 'fetchGeneralWorkersByVolunteerId']);
    });

    Route::group(array('prefix' => 'pollingStations'), function() {
        Route::get("/{assemblyId}", [PollingStationController::class, 'fetchPollingStationByAssemblyId']);
        Route::post("/", [PollingStationController::class, 'updatePollingStation']);
        Route::get("/{pollingId}/volunteers", [PollingStationController::class, 'fetchVolunteerByPollingId']);
        Route::get("/{userParentId}/workers", [PollingStationController::class, 'fetchGeneralWorkersByPollingId']);
    });

    Route::group(array('prefix' => 'assembly'), function() {

        Route::get("/admin/dashboard/{assemblyId}", [AssemblyAdminDashboard::class, 'get_report']);

    });

});




Route::group(array('prefix' => 'dev'), function() {

    Route::get("/{assemblyVolunteerId}/members", [AssemblyController::class, 'fetchGeneralWorkersByAssemblyVolunteerId']);

    Route::get("/booth/{boothId}", [PersonController::class, 'fetchGeneralWorkersByBoothId']);

    Route::group(array('prefix' => 'assembly'), function() {

        Route::get("/", [AssemblyController::class, 'index']);
        Route::get("/district/{id}", [AssemblyController::class, 'fetchAssemblyByDistrictId']);

        Route::get("/allData", [AssemblyController::class, 'fetchAssemblyConstituenciesAlongWithDistricts']);
        Route::get("/admin/dashboard/{assemblyId}", [AssemblyAdminDashboard::class, 'get_report']);

    });
    // Route::group(array('prefix' => 'states'), function() {

    //     Route::get("/", [StateController::class, 'index']);
    // });

    Route::group(array('prefix' => 'pollingStations'), function() {

        Route::get("/{assemblyId}", [PollingStationController::class, 'fetchPollingStationByAssemblyId']);
        Route::get("/{pollingId}/volunteers", [PollingStationController::class, 'fetchVolunteerByPollingId']);
        Route::get("/{userParentId}/workers", [PollingStationController::class, 'fetchGeneralWorkersByPollingId']);
    });

    Route::get("states",[StateController::class, 'index']);
    Route::get("states/{id}",[StateController::class, 'index_by_id']);

    Route::group(array('prefix' => 'person'), function() {

        Route::get("/assembly/{id}", [PersonController::class, 'showPersonByAssembly']);
        Route::post("/", [PersonController::class, 'store']);
    });

    Route::group(array('prefix' => 'pollingAgent'), function() {

        Route::post("/", [PersonController::class, 'createPollingAgent']);
    });

    Route::group(array('prefix' => 'legislative'), function() {

        Route::get("/{userParentId}", [LegislativeController::class, 'showVolunteersByPollingStationId']);
        Route::post("/", [LegislativeController::class, 'storeVolunteer']);
    });

    Route::group(array('prefix' => 'volunteer'), function() {

        Route::post("/", [PollingVolunteer::class, 'storePollingStationGeneralMember']);
        Route::get("/{volunteerId}/workers", [VolunteerController::class, 'fetchGeneralWorkersByVolunteerId']);
    });

    Route::get("logout",[UserController::class,'logout']);


    Route::get("users",[UserController::class,'index']);

    //Area
    Route::get("getAllArea",[AreaController::class, 'get_area']);
});

