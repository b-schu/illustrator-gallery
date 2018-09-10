<?php

// Login and Home
Auth::routes();
Route::get('/home', 'HomeController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
	// Images
	Route::post("/addimg","ImagesController@addimg");
	Route::get("/editimg", "ImagesController@editimg");
	Route::post("/updateimg","ImagesController@updateimg");
	Route::get("/deleteimg", "ImagesController@deleteimg");
	Route::get("/viewimgs", "ImagesController@viewimgs");
	Route::get("/moveimg", "ImagesController@moveimg");

	// Courses
	Route::post("/addcourse","CourseController@addcourse");
	Route::get("/editcourse", "CourseController@editcourse");
	Route::post("/updatecourse", "CourseController@updatecourse");
	Route::get("/deletecourse", "CourseController@deletecourse");
	Route::get("/viewcourses", "CourseController@viewcourses");
	Route::get("/movecourse", "CourseController@movecourse");
});

// Public Pages
Route::get('/', function () { return view('welcome'); });
Route::get("/gallery", "ImagesController@gallery");
Route::get("/courses", "CourseController@gallery");
Route::get("/social", "SocialController@gallery");
Route::post("/sendmail", "SocialController@sendmail");
Route::get("/galleryajax", "ImagesController@galleryajax");


