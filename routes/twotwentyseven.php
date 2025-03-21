<?php

use App\Models\Customer;
use App\Tools\DeveloperTest;
use Illuminate\Support\Facades\Route;
use App\Services\VatService;
use Pest\ArchPresets\Custom;

//question number 1
Route::get('/question-1', function () {
    DeveloperTest::logData('This is a test', ['code' => 1234, 'user_id' => 'abcd123']);
})->name('question.one');

//question number 2a and 2b
Route::get('/question-2', function (VatService $vatService) {

    $value = 100;

    $totalWithVat = $vatService->addVat($value);
    $vatAmount = $vatService->calculateVatAmount($value);

    return response()->json([
        'value' => $value,
        'vat_percentage' => $vatService->getVatPercentage(),
        'vat_amount' => $vatAmount,
        'total_with_vat' => $totalWithVat,
    ]);

})->name('question.two');

//question number 3
Route::get('/question-3', function () {

    $geoIpData = app('geoIpData');
    dd($geoIpData);
    
})->middleware('geo.ip')->name('question.three');

//question number 4
Route::get('/question-4', function (DeveloperTest $developerTest) {

    $developerTest2 = app(DeveloperTest::class);
    $developerTest3 = resolve(DeveloperTest::class);

    

    if($developerTest2 === $developerTest3 && $developerTest2 === $developerTest) {
        return 'All instances are the same.';
    }


})->name('question.four');

//question number 5
Route::get('/question-5', function () {

    $customerIds = [1,2,3,4,5,6,7,8,9,10];


    $customers = Customer::query()
    ->whereIn('id', $customerIds)
    ->where('id', '>', 5)
    ->where('score', '>', 100)
    ->with(['bookings'])
    ->get();
    $customerCount = $customers->count();
    $allBookings = $customers->pluck('bookings')->flatten();
    
    echo 'There are '.$customerCount.' customers with an ID > 5 and score > 100';
    dump($customers);
    dump($allBookings);



})->name('question.five');

//question number 8
Route::get('/question-8', function () {

    
    return response()->json([
        'message' => 'You have access to this route between 9 AM and 5 PM',
    ]);

})->middleware(['role.time.request.limit'])->name('question.eight');

