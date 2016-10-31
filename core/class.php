<?php

class Review
{
	// Properties of Review
	public $uniqueId;
	public $movieName;
	public $userId;
	public $rating;
	public $date;
	public $reviewText;

	// construct Review
	public function __construct($uniqueId, $movieName, $userId, $rating, $date, $reviewText) {
		$this->uniqueId = $uniqueId;
		$this->movieName = $movieName;
        $this->userId = $userId;
        $this->rating = intval($rating);
        $this->date = $date;
        $this->reviewText = $reviewText;
    }

    public function formatDate($date) {
  		$newDate = DateTime::createFromFormat('F j, Y ', $date);
		return date_format($newDate, 'Y-m-d');
    }
}

class PageBuilder
{
	public function moviePage($movieTitle) {
		require("config/config.php");

		$sql = "SELECT reviewText FROM Reviews WHERE movieName='" . $movieTitle . "'";

		$result = mysqli_query($connect,$sql);

		$reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);

		$reviews = array_values($reviews);

		$words = array();
		$word_count = array();

		foreach( $reviews as $review) {
			foreach( $review as $value) {
				$review_words = explode(' ', $value);
				$words = array_merge($words, $review_words);
			}
		}

		$word_blacklist = ["the","but","and","a","to","of","is","it","in","that","i","was","this","but","movie","his","really","as","with","for","film","he","from","very","from","very","on","are","one","like","some","so","by","by","all","film","have","more","about","got","get","which","been","an","just","just","film.","will","not","or","were","gets","far","when","did","its","if","you","be","what","time","at","it&#39;s","watched","would","great","my","me","am","say","no","out","going","finally","movies"];

		$words = array_map('strtolower', $words);

		$words = array_diff($words, $word_blacklist);

		$counted_words = array_count_values(array_filter($words));

		arsort($counted_words);

		arsort($counted_words);
		echo "<table><tr><th>Words</th><th>Count</th></tr>";

		foreach ($counted_words as $key => $val) {
		    echo "<tr><td>" . $key . "</td><td>" . $val ."</td></tr>";
		}

		echo "</table>";

		echo $reviews;

		mysqli_close($connect);
	}
}