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