<?php

Route::get('/stress/alive', ['uses' => 'StressTest\Controllers\StressTestController@alive']);
Route::get('/stress/db-connected', ['uses' => 'StressTest\Controllers\StressTestController@isDbConnected']);
Route::get('/stress/open-db-connections', ['uses' => 'StressTest\Controllers\StressTestController@getOpenDbConnections']);
Route::post('/stress/close-db-connection', ['uses' => 'StressTest\Controllers\StressTestController@closeDbConnection']);
Route::post('/stress/db/eloquent/fetch-all', ['uses' => 'StressTest\Controllers\StressTestController@eloquentFetchAll']);