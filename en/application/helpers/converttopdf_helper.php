<?php

function converttopdf($filePath)
{
    /* $content = file_get_contents($filePath);
    $endpoint = "https://api.zamzar.com/v1/jobs";
    $apiKey = "07826997b2bdb68c5c2d72efc5e1070161fe300a";
    $sourceFile = $filePath;
    $targetFormat = "pdf";

    $postData = array(
      "source_file" => $sourceFile,
      "target_format" => $targetFormat,
      "source_format" => "doc"
    );

    $ch = curl_init(); // Init curl
    curl_setopt($ch, CURLOPT_URL, $endpoint); // API endpoint
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":"); // Set the API key as the basic auth username
    $body = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($body, true);
    $jobID = $response["id"];
    sleep(30);
    $endpoint = "https://api.zamzar.com/v1/jobs/$jobID";
    $ch = curl_init(); // Init curl
    curl_setopt($ch, CURLOPT_URL, $endpoint); // API endpoint
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":"); // Set the API key as the basic auth username
    $body = curl_exec($ch);
    curl_close($ch);
    $job = json_decode($body, true);
    $fileID = $job["target_files"][0]["id"];
    $localFilename = "/var/www/html/converted.pdf";
    $endpoint = "https://api.zamzar.com/v1/files/$fileID/content";
    $ch = curl_init(); // Init curl
    curl_setopt($ch, CURLOPT_URL, $endpoint); // API endpoint
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":"); // Set the API key as the basic auth username
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    $fh = fopen($localFilename, "wb");
    curl_setopt($ch, CURLOPT_FILE, $fh);

    $body = curl_exec($ch);
    curl_close($ch);

    return $localFilename; */
}
