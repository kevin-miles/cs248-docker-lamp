<?php
// Turn off built-in error reporting
error_reporting(0);
mysqli_report(MYSQLI_REPORT_OFF);

// Function for reporting errors
function die_json($response_code, $title = "N/A", $message = "N/A", $db = null, $stmt = null) {
  http_response_code($response_code);
  $error = array("error"=>true, "title"=>$title, "message"=>$message);
  if ($stmt != null) { $stmt->close(); }
  if ($db != null) { $db->close(); }
  die(json_encode($error));
}

// Constants
$MOVIE_COUNT = 565;
$MIN_PER_PAGE = 10;
$MAX_PER_PAGE = 200;

// Let the browser know we are returning JSON instead of HTML
header('Content-Type: application/json');

// TODO: Retrieve orderBy, perPage, and page from $_GET

// TODO: Sanitize page and perPage (ensure in valid range)
//       Use the Constants defined at the top of the file.

// TODO: Compute offset from page and perPage

// TODO: Sanitize orderBy (map the integers to column names, use NULL for no sorting)

// 1. CONNECT to the DB
$db = new mysqli("database", "WebUser", "1ae5b321-dd5f-4562-8fee-b23d9dba044e", "myflix");

// NOTE: Always check for errors and output a message like this if something goes wrong
if ($db->connect_errno) {
  die_json(500, "DB Connection Failed", $db->connect_error);
}

// TODO: 2. PREPARE the query (use ORDER BY, LIMIT, and OFFSET and prepare to bind params for LIMIT and OFFSET)

// TODO: 3. BIND params and EXECUTE the query

// TODO: 4. RETRIEVE all the results

// TODO: 5. Output the full results as JSON (or error if nothing returned)

// TODO: Clean up (CLOSE all resources)
?>
