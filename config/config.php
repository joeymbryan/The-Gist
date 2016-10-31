<?php
    // open mysql connection
    $host = "localhost:8889";
    $username = "root";
    $password = "root";
    $dbname = "movie_review";
    $connect = mysqli_connect($host, $username, $password, $dbname) or die('Error in Connecting: ' . mysqli_error($connect));