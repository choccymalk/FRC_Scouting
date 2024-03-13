<?php

// Specify the directory path
$directoryPath = './uploads';

// Get the list of JSON files in the directory
$jsonFiles = glob($directoryPath . '/*.json');

// Function to combine JSON files into a single associative array
function combineJsonFiles($filePaths)
{
    $combinedData = [];

    foreach ($filePaths as $filePath) {
        // Read JSON file
        $jsonData = file_get_contents($filePath);

        // Decode JSON data into an associative array
        $data = json_decode($jsonData, true);

        // Merge data into the combined array
        $combinedData = array_merge_recursive($combinedData, $data);
    }

    return $combinedData;
}

// Function to convert associative array to CSV and output to the browser
function arrayToCsvDownload($data, $outputFileName = 'combined_data.csv')
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $outputFileName . '"');

    $output = fopen('php://output', 'w');

    // Write CSV header
    fputcsv($output, array_keys(reset($data)));

    // Write CSV rows
    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
}

// Combine JSON files into a single associative array
$combinedData = combineJsonFiles($jsonFiles);

// Output combined data as CSV
arrayToCsvDownload($combinedData);

?>