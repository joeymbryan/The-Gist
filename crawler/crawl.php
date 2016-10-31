<?php

require("../config/config.php");
include_once("../lib/simple_html_dom.php");
require("../core/class.php");

### Begin Crawler -> Database ####

$title = $_GET['title'];

// Connect and Prepare DB Connection
	// use prepare statement for insert query
	$st = mysqli_prepare($connect, 'INSERT INTO Reviews(uniqueId, movieName, UserId, rating, release_date, reviewText) VALUES (?, ?, ?, ?, ?, ?)');

// open the web page
for($x = 1; $x <= 20; $x++) {

	

	// set target url to crawl
	$url = "https://www.rottentomatoes.com/m/" . $title . "/reviews/?page=" . $x . "&type=user"; // change this

	$html = file_get_html($url);
	

	// crawl the webpage for reviews
	foreach($html->find("div.review_table_row") as $singleReview){

		$userId = $singleReview->find("a.articleLink",0)->href;
		$userId = str_replace('/user/id/', '', $userId);
		$userId = str_replace('/','', $userId);

		$rating =  $singleReview->find("div.scoreWrapper span",0)->class; // add class

		$date = $singleReview->find("div.col-xs-16 span.subtle",0)->plaintext;
		$date = Review::formatDate($date);

		$reviewText = $singleReview->find("div.user_review",0)->plaintext;

		$uniqueId = $title . '_' . $date . '_' . $userId;

	    $review = new Review($uniqueId, $title, $userId, $rating, $date, $reviewText);

		// bind variables to insert query params
		mysqli_stmt_bind_param($st, 'ssssss', $uniqueId, $title, $userId, $rating, $date, $reviewText);
	    

	    // execute insert query
	    mysqli_stmt_execute($st);
	}
	//close connection
	echo "loop " . $x . " \n";
	
}

mysqli_close($connect);

echo "done looping";





### End Crawler -> Database ####