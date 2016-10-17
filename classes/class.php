<?php

class Review
{
	// Properties of Review
	public $userId;
	public $rating;
	public $date;
	public $reviewText;

	// construct Review
	public function __construct($userId, $rating, $date, $reviewText) {
        $this->userId = $userId;
        $this->rating = intval($rating);
        $this->date = self::formatDate($date);
        $this->reviewText = $reviewText;
    }

    public function formatDate($date) {
  		$newDate = DateTime::createFromFormat('F j, Y ', $date);
		return date_format($newDate, 'Y-m-d');
    }
}