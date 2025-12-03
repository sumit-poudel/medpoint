<?php
session_start();
$conn = new mysqli("localhost", "root", "", "medpointdb");
if (isset($_SESSION["username"])) {
    if (isset($_GET["q"])) {
        $query = $_GET["q"];
        $username = $_SESSION["username"];
        // Process the query
        switch ($query) {
            case "all":
                // all item in cart status to delivered for user
                $sql = "UPDATE tbcart set isdelivered = 1 WHERE username = '$username'";
                if (mysqli_query($conn, $sql)) {
                    echo "success";
                } else {
                    http_response_code(500);
                    die("Database error");
                }
                break;
            case "one":
                $id = $_GET["id"];
                $quantity = $_GET["quantity"];
                $date = date("Y-m-d");

                $sqlgetstock = "SELECT stock FROM tbproduct WHERE id = $id";
                $result = mysqli_query($conn, $sqlgetstock);
                $row = mysqli_fetch_assoc($result);
                if ($quantity > $row["stock"]) {
                    http_response_code(400);
                    die("Insufficient stock");
                }
                $sqlCheck = "SELECT * FROM tbcart WHERE username='$username' AND pid=$id AND isdelivered=1 AND buydate='$date'";
                $resultCheck = mysqli_query($conn, $sqlCheck);
                if (mysqli_num_rows($resultCheck) > 0) {
                    $sqlupdatecart = "UPDATE tbcart SET quantity = quantity + $quantity WHERE username = '$username' AND pid = $id AND isdelivered = 1 AND buydate = '$date'";
                    $sqlupdateStock = "UPDATE tbproduct SET stock = stock - $quantity WHERE id = $id";
                    if (
                        mysqli_query($conn, $sqlupdatecart) &&
                        mysqli_query($conn, $sqlupdateStock)
                    ) {
                        echo $row["stock"] - $quantity;
                    } else {
                        http_response_code(500);
                        die("Database error");
                    }
                } else {
                    $sqlinsertdelivered = "INSERT INTO tbcart (username, pid, quantity, isdelivered, buydate) VALUES ('$username', $id, $quantity, 1, '$date')";
                    $sqlupdateStock = "UPDATE tbproduct SET stock = stock - $quantity WHERE id = $id";

                    if (
                        mysqli_query($conn, $sqlinsertdelivered) &&
                        mysqli_query($conn, $sqlupdateStock)
                    ) {
                        echo $row["stock"] - $quantity;
                    } else {
                        http_response_code(500);
                        die("Database error");
                    }
                }
                break;
            default:
                http_response_code(404);
                break;
        }
    }
    exit();
} else {
    http_response_code(403);
    die("You are not logged in.");
}
?>
