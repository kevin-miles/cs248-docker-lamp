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

        <section class="">
            <h2 class="display-4 mb-4 fst-italic"><mark class="bg-info">Order Form</mark></h2>
            <form class="row g-3" action="receipt.php" method="post">
                <div class="col-6">
                    <label class="form-label">
                        <h3 class="display-6">Pizza Size</h3>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="8" name="pizza_size" id="pizzaSize8">
                        <label class="form-check-label" for="pizzaSize8">
                            8"
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="12" name="pizza_size" id="pizzaSize12"
                            checked>
                        <label class="form-check-label" for="pizzaSize12">
                            12"
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="16" name="pizza_size" id="pizzaSize16">
                        <label class="form-check-label" for="pizzaSize16">
                            16"
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <label for="crust" class="form-label">
                        <h3 class="display-6">Crust Type</h3>
                    </label>
                    <select id="crust" name="crust" class="form-select">
                        <option selected>Hand Tossed</option>
                        <option>Thin</option>
                        <option>Deep Dish</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">
                        <h3 class="display-6">Toppings</h3>
                    </label>
                    <p class="text-primary fst-italic"><mark class="bg-warning">$1.49</mark></p>
                    <div class="form-check">
                        <input class="form-check-input" name="toppings[]" value="Mozzarella Cheese" type="checkbox"
                            id="mozz" checked>
                        <label class="form-check-label" for="mozz">
                            Mozzarella Cheese
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="toppings[]" value="Cheddar Cheese" type="checkbox"
                            id="cheddar">
                        <label class="form-check-label" for="cheddar">
                            Cheddar Cheese
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="toppings[]" value="Feta Cheese" type="checkbox" id="feta">
                        <label class="form-check-label" for="feta">
                            Feta Cheese
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="toppings[]" value="Onion" type="checkbox" id="onion">
                        <label class="form-check-label" for="onion">
                            Onions
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="toppings[]" value="Peppers" type="checkbox" id="peppers">
                        <label class="form-check-label" for="peppers">
                            Peppers
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <label class="form-label">
                        <h3 class="display-6">Premium Toppings</h3>
                    </label>
                    <p class="text-primary fst-italic"><mark class="bg-warning">$2.99</mark></p>
                    <div class="form-check">
                        <input class="form-check-input" name="premium_toppings[]" value="Pepperoni" type="checkbox"
                            id="pepperoni">
                        <label class="form-check-label" for="pepperoni">
                            Pepperoni
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="premium_toppings[]" value="Italian Sausage"
                            type="checkbox" id="italiansausage">
                        <label class="form-check-label" for="italiansausage">
                            Italian Sausage
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="premium_toppings[]" value="Beef" type="checkbox"
                            id="beef">
                        <label class="form-check-label" for="beef">
                            Beef
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="premium_toppings[]" value="Chicken" type="checkbox"
                            id="chicken">
                        <label class="form-check-label" for="chicken">
                            Chicken
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="premium_toppings[]" value="Gyro" type="checkbox"
                            id="gyro">
                        <label class="form-check-label" for="gyro">
                            Gyro Meat
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">
                        <h3 class="display-6">Round up to Donate</h3>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" name="donation" type="checkbox" id="donation">
                        <label class="form-check-label" for="donation">
                            Round up for a donation to the Fox-Wolf Rivershed Alliance?
                        </label>
                    </div>
                </div>
                <div class="col-12 pt-4">
                    <button type="submit" value="on" name="place_order" class="btn btn-primary">Place Order</button>
                </div>
            </form>
        </section>

        <footer class="mt-4 pt-2">
            <p>CS 248 @ UW Stout | &copy; 2026 Kevin Miles</p>
        </footer>
    </div>
</body>

</html>