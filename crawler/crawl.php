<?php

require("../config/config.php");
include_once("../lib/simple_html_dom.php");
require("../core/class.php");

### Begin Crawler -> Database ####

$title = $_GET['title'];

// Connect and Prepare DB Connection
// use prepare statement for insert query
$movieSt = mysqli_prepare($connect, 'INSERT INTO Movies(movieName, crawlDate, releaseDate) VALUES (?, ?, ?)');
$reviewSt = mysqli_prepare($connect, 'INSERT INTO Reviews(uniqueId, movieName, UserId, rating, reviewDate, reviewText) VALUES (?, ?, ?, ?, ?, ?)');

// crawl 20 pages of Reviews

// set target url to crawl
$url = "https://www.rottentomatoes.com/m/" . $title . "/reviews/?page=" . $x . "&type=user"; // change this

$html = file_get_html($url);

$releaseDate = ;
$crawlDate = ;
$plainTitle
// bind variables to insert query params for Movie
mysqli_stmt_bind_param($movieSt, 'sss', $title, $releaseDate, $crawlDate);

// execute insert query
mysqli_stmt_execute($movieSt);

for($x = 1; $x <= 20; $x++) {

	// crawl the webpage for reviews
	foreach($html->find("div.review_table_row") as $singleReview){

		$userId = $singleReview->find("a.articleLink",0)->href;
		$userId = str_replace('/user/id/', '', $userId);
		$userId = str_replace('/','', $userId);

		$rating =  $singleReview->find("div.scoreWrapper span",0)->class; // add class

		$reviewText = $singleReview->find("div.user_review",0)->plaintext;

		$reviewDate = $singleReview->find("div.col-xs-16 span.subtle",0)->plaintext;
		$reviewDate = Review::formatDate($releaseDate);

		$uniqueId = $title . '_' . $reviewDate . '_' . $userId;

	    $review = new Review($uniqueId, $title, $userId, $rating, $reviewDate, $reviewText);

		// bind variables to insert query params
		mysqli_stmt_bind_param($reviewSt, 'ssssss', $uniqueId, $title, $userId, $rating, $reviewDate, $reviewText);
	    

	    // execute insert query
	    mysqli_stmt_execute($reviewSt);
	}
	//close connection
	echo "loop " . $x . " \n";
	
}

mysqli_close($connect);

echo "done looping";





### End Crawler -> Database ####