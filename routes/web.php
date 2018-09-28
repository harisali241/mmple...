<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::post("logout", function(){
	Auth::logout();
	return redirect('login');
});

Route::get('/', 'HomeController@index')->name('home');
Route::resource('user' , 'UserController');
Route::resource('movie' , 'MovieController');
Route::resource('distributer' , 'DistributerController');
Route::resource('moviePerson' , 'MoviePersonController');
Route::resource('ticket' , 'TicketController');
Route::resource('deal' , 'DealController');
Route::resource('item' , 'ItemController');
Route::resource('foodCategories' , 'FoodCategoriesController');
Route::resource('package' , 'PackageController');
Route::resource('foodStall' , 'foodStallController');
Route::resource('voucher' , 'VoucherController');
Route::resource('screen' , 'ScreenController');
Route::resource('timing' , 'TimingController');
Route::resource('showTime' , 'ShowTimeController');
Route::resource('privateShowTime' , 'PrivateShowTimeController');
Route::resource('logo' , 'LogoController');
Route::resource('slideShow' , 'SlideShowController');
Route::resource('setting' , 'SettingController');


//**************************** Terminals Route *********************************************
Route::get('/terminal' , 'BookTicketController@terminal')->name('terminal');
Route::get('/booking' , 'BookTicketController@booking')->name('bookTicket');
Route::get('/reprintTickets' , 'BookTicketController@reprintTickets')->name('reprintTickets');
Route::get('/cancelTicket' , 'PrintedTicketController@cancelTicket')->name('cancelTicket');
Route::get('/cancelLockedSeat' , 'BookTicketController@cancelLockedSeat')->name('cancelLockedSeat');
Route::get('advBooking', 'AdvanceBookingController@advBooking')->name('advanceBooking');
Route::resource('viewReserve', 'AdvanceBookingController');
Route::get('/bookConcession' , 'BookConcessionController@bookConcession')->name('bookConcession');
Route::get('/cancelConcession' , 'BookConcessionController@cancelConcession')->name('cancelConcession');
Route::get('/voucherConcession' , 'BookConcessionController@voucherConcession')->name('voucherConcession');

Route::get('/viewAndPrint', 'PrintedTicketController@viewAndPrint');
Route::get('confrimAdvBooking', 'AdvanceBookingController@confrimAdvBooking')->name('confrimAdvBooking');
Route::get('/viewAndPrint_c', 'PrintedTicketController@viewAndPrint_c');
Route::get('/reprintConcession/{id}', 'PrintedTicketController@reprintConcession')->name('reprintConcession');
Route::get('/printRecentTicket' , 'PrintedTicketController@printRecentTicket')->name('printRecentTicket');

//**************************** Ajax Route *********************************************
	
	/**///================= DashBoard ================================//
	/**/Route::post('/dashbordMovies', 'HomeController@dashbordMovies');
	/**/Route::post('/dashbordTopSellers', 'HomeController@dashbordTopSellers');
	/**/Route::post('/dashbordticketSales', 'HomeController@dashbordticketSales');
	/**/Route::post('/dashbordConSales', 'HomeController@dashbordConSales');
	/**///================= DashBoard ================================//

	/**///======Booking Ticket================================//
	// /**/Route::post('/searchShowTime', 'AjaxController@searchShowTime');
	/**/Route::get('/allMovies', 'AjaxController@allMovies');
	/**/Route::get('/movieStatus', 'AjaxController@movieStatus');
	/**/Route::post('/getItemPrice', 'AjaxController@itemPrice');
	/**/Route::post('/getTicketPrice', 'AjaxController@ticketPrice');
	/**/Route::post('getScreenSeats', 'AjaxController@getScreenSeats');
	/**/Route::post('holdBookingAndGetSeats', 'AjaxController@holdBookingAndGetSeats');
	/**/Route::post('getAllSeat', 'AjaxController@getAllSeat');
	/**/Route::post('holdSeats', 'AjaxController@holdSeats');
	/**/Route::post('deleteSeat', 'AjaxController@deleteSeat');
	/**/Route::post('cancelAllSelectedSeats', 'AjaxController@cancelAllSelectedSeats');
	/**/Route::post('ticketDelete', 'AjaxController@ticketDelete');
	/**/Route::post('bookTickets', 'AjaxController@bookTickets');
	/**/Route::post('removeAdvHoldBooking', 'AjaxController@removeAdvHoldBooking');
	/**/Route::post('searchCancelSeat', 'AjaxController@searchCancelSeat');
	/**/Route::post('deleteLockedSeat', 'AjaxController@deleteLockedSeat');
	/**///======Booking Ticket================================//

	/**///======Cancel Ticket================================//
	/**/Route::post('searchCancelTicket', 'AjaxController@searchCancelTicket');
	/**/Route::post('deleteTickets', 'AjaxController@deleteTickets');
	/**///======Cancel Ticket================================//

	/**///======Advance Ticket================================//
	/**/Route::post('holdAdvSeats', 'AjaxController@holdAdvSeats');
	/**/Route::post('deleteAdvSeat', 'AjaxController@deleteAdvSeat');
	/**/Route::post('holdAdvBookingAndGetSeats', 'AjaxController@holdAdvBookingAndGetSeats');
	/**/Route::post('bookAdvTickets', 'AjaxController@bookAdvTickets');
	/**///======Advance Ticket================================//

	/**///======Concession booking================================//
	/**/Route::post('bookCon', 'AjaxController@bookCon');
	/**/Route::post('cancelCon', 'AjaxController@cancelCon');
	/**/Route::post('voucherRecord', 'AjaxController@voucherRecord');
	/**/Route::post('printConcession', 'AjaxController@printConcession');
	/**///======Concession booking================================//

	/**///======Deals================================//
	/**/Route::post('/getShowTimeByMovie', 'AjaxController@getShowTimeByMovie');
	/**///======Deals================================//

//**************************** Ajax Route *********************************************

//**************************** Reports Route ******************************************
Route::get('movieReport', 'ReportController@movie');
Route::get('concessionReport', 'ReportController@concession');
Route::get('customReport', 'ReportController@custom');

Route::get('filmsByDistributor', 'ReportController@filmsByDistributor')->name('filmsByDistributor');
Route::get('showsByTime', 'ReportController@showsByTime')->name('showsByTime');
Route::get('weeklyMovieReport', 'ReportController@weeklyMovieReport')->name('weeklyMovieReport');

Route::post('filmsByDistributorReports', 'ReportController@filmsByDistributorReports');
Route::post('showsByTimeReports', 'ReportController@showsByTimeReports');
Route::post('weeklyMovieReports', 'ReportController@weeklyMovieReports');

Route::get('itemSales', 'ReportController@itemSales')->name('itemSales');
Route::post('itemSalesReq', 'ReportController@itemSalesReq');

Route::get('singleItemSales', 'ReportController@singleItemSales')->name('singleItemSales');
Route::post('singleItemSalesReq', 'ReportController@singleItemSalesReq');

Route::get('singleItemSalesByUser', 'ReportController@singleItemSalesByUser')->name('singleItemSalesByUser');
Route::post('singleItemSalesByUserReq', 'ReportController@singleItemSalesByUserReq');

Route::get('packageSales', 'ReportController@packageSales')->name('packageSales');
Route::post('packageSalesReq', 'ReportController@packageSalesReq');

Route::get('singlePackageSales', 'ReportController@singlePackageSales')->name('singlePackageSales');
Route::post('singlePackageSalesReq', 'ReportController@singlePackageSalesReq');

Route::get('packageSalesByUser', 'ReportController@packageSalesByUser')->name('packageSalesByUser');
Route::post('packageSalesByUserReq', 'ReportController@packageSalesByUserReq');

Route::get('concessionCancellationByDay', 'ReportController@concessionCancellationByDay')->name('concessionCancellationByDay');
Route::post('concessionCancellationByDayReq', 'ReportController@concessionCancellationByDayReq');

Route::get('concessionSaleByAllUser', 'ReportController@concessionSaleByAllUser')->name('concessionSaleByAllUser');
Route::post('concessionSaleByAllUserReq', 'ReportController@concessionSaleByAllUserReq');

Route::get('totalSeatBookingByDay', 'ReportController@totalSeatBookingByDay')->name('totalSeatBookingByDay');
Route::post('totalSeatBookingByDayReq', 'ReportController@totalSeatBookingByDayReq');

Route::get('currentSeatBookingByDay', 'ReportController@currentSeatBookingByDay')->name('currentSeatBookingByDay');

Route::get('advanceBookingByDay', 'ReportController@advanceBookingByDay')->name('advanceBookingByDay');
Route::post('advanceBookingByDayReq', 'ReportController@advanceBookingByDayReq');

Route::get('ticketSalesByMovie', 'ReportController@ticketSalesByMovie')->name('ticketSalesByMovie');
Route::post('ticketSalesByMovieReq', 'ReportController@ticketSalesByMovieReq');

Route::get('numberOfTicketSalesByMovie', 'ReportController@numberOfTicketSalesByMovie')->name('numberOfTicketSalesByMovie');

Route::get('advanceTicketSalesByMovie', 'ReportController@advanceTicketSalesByMovie')->name('advanceTicketSalesByMovie');
Route::post('advanceTicketSalesByMovieReq', 'ReportController@advanceTicketSalesByMovieReq');

Route::get('numberOfAdvanceTicketSalesByMovie', 'ReportController@numberOfAdvanceTicketSalesByMovie')->name('numberOfAdvanceTicketSalesByMovie');

Route::get('cashInHandByDay', 'ReportController@cashInHandByDay')->name('cashInHandByDay');
Route::post('cashInHandByDayReq', 'ReportController@cashInHandByDayReq');

Route::get('cashInHandByUser', 'ReportController@cashInHandByUser')->name('cashInHandByUser');
Route::post('cashInHandByUserReq', 'ReportController@cashInHandByUserReq');

Route::get('ticketCancellationByDay', 'ReportController@ticketCancellationByDay')->name('ticketCancellationByDay');
Route::post('ticketCancellationByDayReq', 'ReportController@ticketCancellationByDayReq');

// Route::get('ticketSalesByUser', 'ReportController@ticketSalesByUser')->name('ticketSalesByUser');
// Route::post('ticketSalesByUserReq', 'ReportController@ticketSalesByUserReq');