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

// Retrieve orderBy, perPage, and page from $_GET
$orderBy = $_GET['orderBy'];
$perPage = $_GET['perPage'];
$page = $_GET['page'];

// Sanitize page and perPage (ensure in valid range)
//       Use the Constants defined at the top of the file.
if ($page < 0) die_json(500, 'Invalid parameters page');
if ($perPage < $MIN_PER_PAGE || $perPage > $MAX_PER_PAGE) die_json(500, 'Invalid parameters per page limits');

// Compute offset from page and perPage
$offset = ($page - 1) * $perPage;


// Sanitize p = $_GorderBy (map the integers to column names, use NULL for no sorting)
$cols = [
  1 => 'id',
  2 => 'title',
  3 => 'year',
  4=> 'rated',
  5=> 'imdbrating',
  6=> 'description',
  7=> 'image',
  8=> 'genres',
  9=> 'directors',
  10=> 'writers',
  11=> 'actors',
];

$sortCol = isset($cols[$orderBy]) ? $cols[$orderBy] : null;


// 1. CONNECT to the DB
$db = new mysqli("database", "WebUser", "1ae5b321-dd5f-4562-8fee-b23d9dba044e", "myflix");

// NOTE: Always check for errors and output a message like this if something goes wrong
if ($db->connect_errno) {
  die_json(500, "DB Connection Failed", $db->connect_error);
}

// 2. PREPARE the query (use ORDER BY, LIMIT, and OFFSET and prepare to bind params for LIMIT and OFFSET)
$sql = "SELECT id, title, year, rated, image, genres FROM movies";
if ($sortCol !== null) $sql .= " ORDER BY " . $sortCol;

$sql .= " LIMIT ? OFFSET ?";
$stmt = $db->prepare($sql);

if (!$stmt) die_json(500, "Prepare Failed", $db->error, $db);

// 3. BIND params and EXECUTE the query
$stmt->bind_param("ii", $perPage, $offset);
$exec_result = $stmt->execute();
if (!$exec_result) die_json(500, "DB query failure", $stmt->error, $db, $stmt);

// 4. RETRIEVE all the results
$result = $stmt->get_result();
if (!$result) die_json(500, "DB query failure", $stmt->error, $db, $stmt);
$data = $result->fetch_all(MYSQLI_ASSOC);

// 5. Output the full results as JSON (or error if nothing returned)
if (count($data) === 0) die_json(404, "No results found", "No records match the requested page parameters.");

http_response_code(200);
echo json_encode($data);

// Clean up (CLOSE all resources)
$stmt->close();
$db->close();
?>
