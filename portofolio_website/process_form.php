<?php
$host = "localhost";
$dbname = "mydatabase";
$username = "root";
$password = "";

$response = array(); // Create an array for the response

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $message = $_POST["message"];

        if($name && $email && $address && $phone && $message != ""){
            $stmt = $conn->prepare("INSERT INTO contact_forms (name, email, address, phone, message) VALUES (:name, :email, :address, :phone, :message)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':message', $message);
            $stmt->execute();

            // Set response to be sent back to HTML
            $response['status'] = 'success';
            $response['message'] = 'Pesan berhasil dikirimkan. Terima kasih saran baiknya!';
        }else{
            $response['status'] = 'error';
            $response['message'] = 'Form kosong, isi pesan terlebih dahulu!';
        }



    }
} catch (PDOException $e) {
    // Set response to be sent back to HTML
    $response['status'] = 'error';
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Sending the response in JSON format
header('Content-Type: application/json');
echo json_encode($response);
?>
