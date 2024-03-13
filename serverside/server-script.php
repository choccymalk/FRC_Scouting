<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if a file was uploaded
    if (isset($_FILES['uploadedFile'])) {

        // File details
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileError = $_FILES['uploadedFile']['error'];

        // Allowed file extensions
        $allowedExtensions = ['png', 'jpg', 'gif', 'webp', 'heic', 'jpeg', 'json'];

        // Get the file extension
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check if the file extension is allowed
        if (in_array($fileExtension, $allowedExtensions)) {

            // Specify the directory where you want to store the uploaded file
            $uploadDirectory = 'uploads/';

            // Create the directory if it doesn't exist
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            // Generate an MD5 hash of the file content
            $md5Hash = md5_file($fileTmpPath);

            // Rename the file to its MD5 hash
            $destinationPath = $uploadDirectory . $md5Hash . '.' . $fileExtension;
            if (move_uploaded_file($fileTmpPath, $destinationPath)) {
                // File was successfully uploaded and renamed
                $response = ['message' => 'File uploaded and renamed successfully', 'file_path' => $destinationPath];
            } else {
                // File upload or rename failed
                $response = ['message' => 'File upload or rename failed'];
            }

        } else {
            // Invalid file type
            $response = ['message' => 'Invalid file type. Allowed types: ' . implode(', ', $allowedExtensions)];
        }

        // Send the response back to the client
        echo json_encode($response);

    } else {
        // No file uploaded
        $response = ['message' => 'No file uploaded'];
        echo json_encode($response);
    }

} else {
    // If the request method is not POST, you can handle it accordingly
    http_response_code(405); // Method Not Allowed
    echo 'Only POST requests are allowed.';
}

?>