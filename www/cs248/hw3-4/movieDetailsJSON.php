<?php
// Turn off built-in error reporting
error_reporting(0);
mysqli_report(MYSQLI_REPORT_OFF);

// Function for reporting errors
function die_json($response_code, $title = "N/A", $message = "N/A", $db = null, $stmt = null) {
  http_response_code($response_code);
  $error = array("error"=>true, "title"=>$title, "message"=>$message);
  $stmt == null || $stmt->close();
  $db == null || $db->close();
  die(json_encode($error));
}

// Let the browser know we are returning JSON instead of HTML
header('Content-Type: application/json');

// Make sure the required id was provided
if(!isset($_GET['id'])) {
  die_json(400, "Missing Parameter", "The 'id' parameter is required");

}

// Get ID of movie from form GET data and store it in a variable
$id = $_GET["id"];
// 1. CONNECT to the database
$db = new mysqli("database", "WebUser", "1ae5b321-dd5f-4562-8fee-b23d9dba044e", "myflix");

// NOTE: Always check for errors and output a message like this if something goes wrong
if ($db->connect_errno) {
  die_json(500, "DB Connection Failed", $db->connect_error);
}

// 2. PREPARE the query (use the movie ID and bind params where you can)
$sql = "SELECT id, title, year, rated, imdbrating, description, image, genres, directors, writers, actors FROM movies WHERE id = ?";
$stmt = $db->prepare($sql);

if (!$stmt) die_json(500, "Prepare Failed", $db->error, $db);

// 3. BIND params and EXECUTE the query
$stmt->bind_param("s", $id);
$exec_result = $stmt->execute();
if (!$exec_result) die_json(500, "DB query failure", $stmt->error, $db, $stmt);

// 4. RETRIEVE the results and make sure there is at least one
$result = $stmt->get_result();
if (!$result) die_json(500, "DB query failure", $stmt->error, $db, $stmt);
$data = $result->fetch_all(MYSQLI_ASSOC); // dont need to use fetch_all, but it keeps things consistent (array of obj returned)

// 5. Output the one result as JSON (or 404 if nothing found)
if (count($data) === 0) die_json(404, "No results found", "No records match the requested page parameters.");

http_response_code(200);
echo json_encode($data);

// Clean up (CLOSE all resources)
$stmt->close();
$db->close();
?>
