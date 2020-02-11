<?php
	use Core\Route;
	
	Route::respond("GET", "/", function() {
		Home_Controller::index();
	});
	
	Route::respond("GET", "/about", function() {
		echo "about";
	});
	
	Route::respond("GET", "/person/(any:id)", function($id) {
		#echo "You found person " . $id;
	});
	
	// Respond to a delete request at the supplied URI
	Route::respond("DELETE", "/house/slytherin", function() {
		echo "Removing Slytherin...";
	});