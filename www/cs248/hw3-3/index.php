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
                        Login
                    </h1>
                </div>


            </div>

        </header>

        <section class="section-signup m-auto w-100">
            <form class="container g-3 needs-validation" method="post" action="validate.php" novalidate>
                <div class="row m-auto mb-3">
                    <div class="col-auto w-100">
                        <label for="email-input" class="col-sm-2 col-form-label">Email</label>
                        <input required type="email" name="email" class="validate-me form-control" id="email-input"
                            placeholder="you@my.uwstout.edu">
                    </div>
                </div>
                <div class="row m-auto mb-3">
                    <div class="col-auto w-100">
                        <div class="col-form-label">Password</div>
                        <label for="password-input" class="col-sm-2 visually-hidden">Password</label>
                        <input required type="password" name="password" class="validate-me form-control mb-2"
                            id="password-input" placeholder="Password">
                    </div>
                </div>
                <div class="row m-auto mb-3">
                    <div id="form-feedback" class="col-auto w-100">
                    </div>
                    <div id="form-success" class="col-auto w-100">
                    </div>
                </div>
                <div class="row m-auto mb-3">
                    <div class="col-auto w-100">
                        <button value="on" name="login" id="submit-button" type="submit"
                            class="btn btn-primary w-100">Sign In</button>
                    </div>
                </div>

            </form>
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