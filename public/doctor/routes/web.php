<?php

use App\Models\Book;
use App\Models\Category;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Auth::routes();

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return 'cach clear success';
});

Route::get('/', function (Request $request) {
    $categories=Category::where('status','active')->get();
    $doctors=Hotel::when($request->text,function($q)use($request){
        $q->whereTranslationLike('name','%' .$request->text. '%');
    })->when($request->category_id,function($q)use($request){
        $q->where('category_id',$request->category_id);
    })->paginate(12);
    return view('home',compact('categories','doctors'));
})->name('index');


Route::get('/book/{id}', function ($id) {
    if(empty(Hotel::find($id)))
    {
        return redirect()->route('index');
    }
    Book::create([
        'hotel_id'=>$id,
        'user_id'=>auth()->user()->id,
    ]);
    return redirect()->route('index');
})->name('book')->middleware('auth');

Route::group(
    [
        'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {

        
        
        Route::get('/dashboard/home','HomeController@index')->name('dashboard.home')->middleware('admin');

        Route::prefix('dashboard')->namespace('Dashboard')->middleware(['auth','admin'])->name('dashboard.')->group(function () {

            Route::resource('users', 'UserController');
            Route::resource('roles', 'RoleController');
            Route::resource('hotels', 'HotelController');

            Route::get('hotelLogin/{id}', 'HotelController@hotelLogin')->name('hotelLogin');
            Route::get('hotelLogout', 'HotelController@hotelLogout')->name('hotelLogout');

            Route::resource('categories', 'CategoryController');
            Route::resource('books', 'bookController');
        });


    });

