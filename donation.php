<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = htmlspecialchars($_POST['donorName']);
    $email = htmlspecialchars($_POST['donorEmail']);
    $amount = htmlspecialchars($_POST['donationAmount']);
    $paymentMethod = htmlspecialchars($_POST['paymentMethod']);
    
    // Payment method details
    $cardNumber = $cardExpiry = $cardCVC = "";
    $paypalEmail = "";
    $accountNumber = $routingNumber = "";

    if ($paymentMethod == 'creditCard' || $paymentMethod == 'debitCard') {
        $cardNumber = htmlspecialchars($_POST['cardNumber']);
        $cardExpiry = htmlspecialchars($_POST['cardExpiry']);
        $cardCVC = htmlspecialchars($_POST['cardCVC']);
    } elseif ($paymentMethod == 'paypal') {
        $paypalEmail = htmlspecialchars($_POST['paypalEmail']);
    } elseif ($paymentMethod == 'bankTransfer') {
        $accountNumber = htmlspecialchars($_POST['accountNumber']);
        $routingNumber = htmlspecialchars($_POST['routingNumber']);
    }

    // Database connection
    $servername = "localhost"; 
    $username = "root";  // replace with your DB username
    $password = "";  // replace with your DB password
    $dbname = "agriculture_site;";  // replace with your DB name

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare SQL statement
    $sql = "INSERT INTO donations (name, email, amount, paymentMethod, cardNumber, cardExpiry, cardCVC, paypalEmail, accountNumber, routingNumber)
            VALUES ('$name', '$email', '$amount', '$paymentMethod', '$cardNumber', '$cardExpiry', '$cardCVC', '$paypalEmail', '$accountNumber', '$routingNumber')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo "Donation successful! Thank you for your support.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
