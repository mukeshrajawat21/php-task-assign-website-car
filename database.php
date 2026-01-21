<?php

$conn = mysqli_connect("localhost", "root", "", "cars_website");

  if(!$conn)
    {
        echo "Database is not connected";
    }

?>