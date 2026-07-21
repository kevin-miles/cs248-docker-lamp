<?php
// constant declarations in cents 
const PRICE_TOPPING_CENTS = 149;
const PRICE_PREM_TOPPING_CENTS = 299;
const PRICE_SIZE_8_CENTS = 899;
const PRICE_SIZE_12_CENTS = 1099;
const PRICE_SIZE_16_CENTS = 1299;

const TAX_RATE = 5.2;
const TAX_RATE_CENTS = 520;

// error check, otherwise start rendering markup
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo '<div class="error">Error: Only POST supported</div>';
    exit;
} else if (!isset($_POST["pizza_size"], $_POST["crust"], $_POST["place_order"])) {
    // implicitly only accepts a "place_order" form
    echo '<div class="error">Error: Missing required POST keys</div>';
    exit;
} else {

    function debug($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        exit;
    }

    function esc_str($string)
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }

    function price_pizza_size($size)
    {
        return match ($size) {
            16 => PRICE_SIZE_16_CENTS,
            12 => PRICE_SIZE_12_CENTS,
            8 => PRICE_SIZE_8_CENTS,
        };
    }

    function display_currency($cents)
    {
        $frac = str_pad($cents % 100, 2, '0', STR_PAD_LEFT);
        $dollars = floor($cents / 100);
        return '$' . $dollars . '.' . $frac;
    }

    function calculate_totals($raw_tax_cents, $subtotal_cents)
    {
        $raw_tax_cents = $subtotal_cents * TAX_RATE_CENTS;

        // 5000 moves the fraction of .5 or larger up to the next cents place
        // less than .5 wont change anything
        // then integer division removes the last 4 digits 
        // leading to a total rounded to the last penny
        $tax_cents = intdiv($raw_tax_cents + 5000, 10000);
        $total_cents = $subtotal_cents + $tax_cents;

        // $total_cents % 100 will get 60 from 460 ($4.60)
        // 100 minus the above gets the change needed to round up
        // but if a flat bill (6.00, 7.00, 8.00 dollars etc.)
        // we dont want to round up to a whole dollar
        // so in that scenario the final "% 100" would turn that back to 0
        $donation_cents = isset($_POST["donation"]) ? ((100 - ($total_cents % 100)) % 100) : 0;
        $total_cents += $donation_cents;
        return [$total_cents, $tax_cents, $donation_cents, $subtotal_cents];
    }

    // collect POST data
    // null check and sanitize
    $pizza_size = (int) esc_str($_POST["pizza_size"]);
    $pizza_size_price = price_pizza_size($pizza_size);
    $crust = esc_str($_POST["crust"]); // no price required, counted with pizza size price
    $toppings = isset($_POST["toppings"]) && is_array($_POST["toppings"]) ? array_map('esc_str', $_POST["toppings"]) : array();
    $toppings_count = count($toppings);
    $toppings_price = $toppings_count * PRICE_TOPPING_CENTS;
    // $place_order = esc_str($_POST["place_order"]);
    $premium_toppings = isset($_POST["premium_toppings"]) && is_array($_POST["premium_toppings"]) ? array_map('esc_str', $_POST["premium_toppings"]) : array();
    $premium_toppings_count = count($premium_toppings);
    $premium_toppings_price = $premium_toppings_count * PRICE_PREM_TOPPING_CENTS;

    // begin calculating tax and totals
    $subtotal_cents = $pizza_size_price + $toppings_price + $premium_toppings_price;
    $raw_tax_cents = $subtotal_cents * TAX_RATE_CENTS;
    [$total_cents, $tax_cents, $donation_cents, $subtotal_cents] = calculate_totals($raw_tax_cents, $subtotal_cents);


    // prepare markup
    $table_body_rows = '<tr><td>' . $pizza_size . ' in. ' . $crust . ' Pizza</td><td>Tomato Sauce</td><td>1</td><td>' . display_currency($pizza_size_price) . '</td></tr>';
    $table_body_rows .= implode('', array_map(function ($topping) {
        return "<tr><td></td><td class=''>{$topping}</td><td>1</td><td>" . display_currency(PRICE_TOPPING_CENTS) . "</td></tr>";
    }, $toppings));
    $table_body_rows .= implode('', array_map(function ($topping) {
        return "<tr><td></td><td class=''>{$topping}</td><td>1</td><td>" . display_currency(PRICE_PREM_TOPPING_CENTS) . "</td></tr>";
    }, $premium_toppings));

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HW 3.2</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
</head>

<body class="bg-light border border-secondary border-5">
    <div class="container">

        <header class="pb-2 mt-4 mb-2">
            <h1 class="display-2">
                Online Pizza Ordering
            </h1>

        </header>

        <section class="row">
            <div class="col-12">
                <section class="row align-items-center">
                    <div class="col-6 text-start">
                        <h2 class="display-4 fst-italic">Receipt</h2>
                    </div>
                    <div class="col-6 text-end">
                        <div>
                            <!-- not worth introducing js file just for this! -->
                            <button class="btn btn-primary" onclick="window.history.back()">Edit Order</button>
                            <a href="/cs248/hw3-2/" class="btn btn-secondary">New Order</a>
                            </button>
                        </div>

                    </div>
                </section>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Toppings</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $table_body_rows; ?>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Subtotal</th>
                            <td><?php echo display_currency($subtotal_cents); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Tax (<?php echo TAX_RATE . "%"; ?>)</th>
                            <td><?php echo display_currency($tax_cents); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Round Up for Donation</th>
                            <td><?php echo display_currency($donation_cents); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Total</th>
                            <td><?php echo display_currency($total_cents); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <footer class="mt-4 pt-2">
            <p>CS 248 @ UW Stout | &copy; 2026 Kevin Miles</p>
        </footer>
    </div>
</body>

</html>