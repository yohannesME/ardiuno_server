<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensor_data";

/*$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);*/

$api_key_value = "tPmAT5Ab3j7F9";


$api_key= $temp = $hum = $moist1 = $moist2 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $temp = test_input($_POST["temp"]);
        $hum = test_input($_POST["hum"]);
        $moist1 = test_input($_POST["moist1"]);
        $moist2 = test_input($_POST["moist2"]);
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
       // Insert the data into the database
        $sql = "INSERT INTO sensor (temperature, humidity, moisture1, moisture2)
        VALUES ($temp, $hum, $moist1,$moist2)";

        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}