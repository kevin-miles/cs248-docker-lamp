<?php
const GENERIC_ERROR_CREDS = "Credentials do not match";

abstract class DBCreds
{
    const HOST = 'database';
    const USERNAME = 'WebUser';
    const DATABASE = 'simpsons';
    const PASSWORD = '1ae5b321-dd5f-4562-8fee-b23d9dba044e';
}

//connect to db
function connectToDB()
{
    // this allows mysql_sql_exception to be thrown when errors occur
    // we need this for our try catch blocks for clean error handling
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = new mysqli(DBCreds::HOST, DBCreds::USERNAME, DBCreds::PASSWORD, DBcreds::DATABASE);

    return $db;
}

$errors = [];


// error check, otherwise start rendering markup
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $errors[] = "Only POST is supported.";
} else if (!isset($_POST["password"], $_POST["email"], $_POST["login"])) {
    $errors[] = "Missing required POST parameters";
} else {
    try {
        // we dont need to escape these
        // the prepared statements will separate the query
        // from the data and neutralizes sql injection
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $mysqli = connectToDB();
        $mysqli->set_charset('utf8mb4');
        $mysqli_stmt = $mysqli->stmt_init();
        $q = "SELECT email, password, name FROM students WHERE email = ?";
        $mysqli_stmt->prepare($q);
        $mysqli_stmt->bind_param("s", $email);
        $mysqli_stmt->execute();
        $mysqli_stmt->store_result();
        $mysqli_stmt->bind_result($fetched_email, $fetched_password, $fetched_name);

        if ($mysqli_stmt->num_rows < 1)
            throw new RuntimeException("Email not found");

        // we have a result, lets fetch it so results are bound
        $mysqli_stmt->fetch();

        // check password against the one in our db
        if ($pass !== $fetched_password)
            throw new RuntimeException("Passwords do not match");
    } catch (mysqli_sql_exception $e) {
        // this will catch any native exceptions thrown by our mysqli calls
        // cleanup
        $mysqli_stmt->close();

        // log error for dev
        error_log($e->getMessage());
        $errors[] = (GENERIC_ERROR_CREDS);

    } catch (RuntimeException $e) {
        // log error for dev
        error_log($e->getMessage());
        $errors[] = (GENERIC_ERROR_CREDS);
    }

}

$has_errors = !empty($errors);
$msg_header = $has_errors ? "Error" : "Success";
$msg_body = $has_errors ? '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>' : "Welcome, $fetched_name!";

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="container">
        <!-- This duplicates the page-header from Bootstrap 3 (but in bootstrap 4+) -->
        <header>
            <div class="mb-3 border-bottom row align-items-center">
                <div class="col-auto">
                    <h1 class="display-2 mb-0">
                        <?= $msg_header; ?>
                    </h1>
                </div>
            </div>

        </header>

        <section class="row">
            <p><?= $msg_body; ?></p>
        </section>


        <footer class="border-top mt-4 pt-2">
            <p>For CS 248 at UW Stout | &copy; 2026 Kevin Miles</p>
        </footer>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="index.js"></script>
</body>

</html>