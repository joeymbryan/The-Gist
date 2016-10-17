<?php

include_once("simple_html_dom.php");
require("classes/class.php");

// set target url to crawl
$url = "https://www.rottentomatoes.com/m/the_revenant_2015/reviews/?type=user"; // change this



// open the web page
$html = new simple_html_dom();
$html->load_file($url);

// array to store scraped reviews
$reviews = array();

// crawl the webpage for reviews
foreach($html->find("div.review_table_row") as $singleReview){
	
	$userId = $singleReview->find("a.articleLink",0)->href;
	$rating =  $singleReview->find("div.scoreWrapper span",0)->class; // add class
	$date = $singleReview->find("div.col-xs-16 span.subtle",0)->plaintext;
	// $newDate = DateTime::createFromFormat('F j, Y ', $date);
	// $date = date_format($newDate, 'Y-m-d');
	// $date = self::formatDate($date);
	$reviewText = $singleReview->find("div.user_review",0)->plaintext;
    $review = new Review($userId, $rating, $date, $reviewText);
    $reviews[] = $review;
}

// $url_2 = "https://www.rottentomatoes.com/m/the_revenant_2015/reviews/?page=2&type=user";
// $html->load_file($url_2);

// foreach($html->find("div.user_review") as $review){
//     array_push($reviews, $review->plaintext);
// }

// remove duplicates from the reviews array
// $reviews = array_unique($reviews);

// $word_count = $word => $count;

// $words = array();
// $word_count = array();

// foreach( $reviews as $review) {
// 	$review_words = explode(' ', $review);
// 	$words = array_merge($words, $review_words);
// }

// $word_blacklist = ["the","but","and","a","to","of","is","it","in","that","i","was","this","but","movie","his","really","as","with","for","film","he","from","very","from","very","on","are","one","like","some","so","by","by","all","film","have","more","about","got","get","which","been","an","just","just","film.","will","not","or","were","gets","far","when","did","its","if","you","be"];

// $words = array_map('strtolower', $words);

// $words = array_diff($words, $word_blacklist);

// // set output headers to download file
// // header("Content-Type: text/csv; charset=utf-8");
// // header("Content-Disposition: attachment; filename=reviews.csv");

// $counted_words = array_count_values(array_filter($words));

// arsort($counted_words);
echo "<table><tr><th>Words</th><th>Count</th></tr>";

// foreach ($counted_words as $key => $val) {
//     echo "<tr><td>" . $key . "</td><td>" . $val ."</td></tr>";
// }

echo var_dump($reviews);

echo "</table>";

// // set file handler to output stream
// $output = fopen("php://output", "w");
// // output the scraped reviews
// fputcsv($output, $words, "\n");
?>