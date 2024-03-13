<?php

// Specify the directory path
$directoryPath = './uploads';

// Get the list of files in the directory
$files = scandir($directoryPath);

// Filter out "." and ".." entries
$files = array_diff($files, array('.', '..'));

// Display the contents of each file
echo '<font face="arial">';
echo '<h2>Files in Directory</h2>';
echo '<ul>';
foreach ($files as $file) {
    $filePath = $directoryPath . '/' . $file;

    // Check if it's a file (not a subdirectory)
    if (is_file($filePath)) {

        // Check the file extension
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Exclude files with the ".json" extension
        if ($fileExtension === 'json') {
            continue;
        }

        echo '<li><strong>' . $file . '</strong>';

        // Display links for download based on file type
        echo ' - <a href="' . $filePath . '" download>Download</a><br>';

        // Display content based on file type
        if (in_array($fileExtension, ['txt', 'php', 'html'])) {
            // Display the content of text files
            $content = file_get_contents($filePath);
            echo '<pre>' . htmlspecialchars($content) . '</pre>';
        } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'heic'])) {
            // Display images
            echo '<img src="' . $filePath . '" alt="' . $file . '" style="max-width: 100%; height: auto;">';
        } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg', 'mov'])) {
            // Display videos
            echo '<video width="320" height="240" controls>';
            echo '<source src="' . $filePath . '" type="video/' . $fileExtension . '">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
        } else {
            // Unsupported file type
            echo '<em>Unsupported file type: ' . $fileExtension . '</em>';
        }

        echo '</li>';
    }
}
echo '</ul>';
echo '</font>';
echo '<p>chatgpt cooked with this code</p>';
?>