<?php
    function createListSection($num) {
        # generate the list items for powers of 2
        $list = "";
        for ($i = 0; $i <= $num; $i++) {
            $list .= "<li class=\"list-group-item\">2<sup>{$i}</sup>=" . number_format(2**$i) . "</li>";
        }

        return <<<EOF
        <section>
            <h2 class="display-4">Powers of 2 List</h2>
            <ul class="list-group">
                {$list}
            </ul>
        </section>
        EOF;
    }

    function createTableSection($col, $row) {
        $theadCells = "";
        $tbodyRows = "";
        for ($x = 1; $x<= $row; $x++) {

            // create container for cells
            $cells = "";

            for ($y = 1; $y <= $col; $y++) {
                
                // first row, thead, all th cells with scope of col
                // 1 - 20 numbers displayed
                if ($x == 1) {
                    $cells .= "<th scope=\"col\">". str_pad($y,3,0,STR_PAD_LEFT ) ."</th>";

                // first column, tbody, all th cells with scope of row
                // 1 - 20 numbers displayed
                } else if ($y == 1){
                    $cells .= "<th scope=\"row\">". str_pad($x,3,0,STR_PAD_LEFT)." </th>";
                
                // all other cells, standard TD with x*y calculated
                } else {
                    $cells .= "<td>" . str_pad($x * $y,3,0, STR_PAD_LEFT) . "</td>";
                }
            }   

            // append it to the body or head
            if ($x == 1) {
                $theadCells .= $cells;
            } else {
                $tbodyRows .= "<tr>{$cells}</tr>";
            }
        }

        return <<<EOF
        <section>
            <h2 class="display-4 mt-2">Multiplication Table</h2>
            <table class="table table-bordered table-striped">
                {$theadCells}
                {$tbodyRows}
            </table>
        </section>
        EOF;
    }
     
        
?>



<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HW 3.1</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">

        <header class="pb-2 mt-4 mb-2">
            <h1 class="display-2">
             HW 3.1 
            </h1>
       
        </header>
       
        <?php echo createListSection(50); ?>
        <?php echo createTableSection(20, 20); ?>
        
        <footer class="mt-4 pt-2">
            <p>CS 248 @ UW Stout | &copy; 2026 Kevin Miles</p>
        </footer>
        </div>
    </body>
</html>
