<?php
session_start();
$conn = new mysqli("localhost", "root", "", "medpointdb");

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];

    //1. add to cart
    if (isset($_GET["id"]) && isset($_GET["quantity"])) {
        $id = $_GET["id"];
        $quantity = $_GET["quantity"];
        //check stock
        $sqlgetstock = "SELECT stock FROM tbproduct WHERE id = $id";
        $result = mysqli_query($conn, $sqlgetstock);
        $row = mysqli_fetch_assoc($result);
        if ($quantity > $row["stock"]) {
            http_response_code(400);
            die("Insufficient stock");
        }
        // Check if the user already has this product in the cart
        $sqlCheck = "SELECT * FROM tbcart WHERE username='$username' AND pid=$id AND isdelivered=0";
        $resultCheck = mysqli_query($conn, $sqlCheck);

        if (mysqli_num_rows($resultCheck) > 0) {
            // Product exists in cart → update cart and stock
            $sqlupdatestock = "UPDATE tbproduct SET stock = stock - $quantity WHERE id = $id";
            $sqlupdatecart = "UPDATE tbcart SET quantity = quantity + $quantity WHERE username='$username' AND pid = $id AND isdelivered=0";
            mysqli_query($conn, $sqlupdatestock);
            mysqli_query($conn, $sqlupdatecart);
            echo $row["stock"] - $quantity;
            exit();
        } else {
            // Product not in cart → insert into cart
            $date = date("Y-m-d");
            $sqlinsert = "INSERT INTO tbcart (username, pid, quantity, buydate)
                          VALUES ('$username', $id, $quantity, '$date')";
            if (mysqli_query($conn, $sqlinsert)) {
                // Reduce stock after insert
                $sqlupdatestock = "UPDATE tbproduct SET stock = stock - $quantity WHERE id = $id";
                mysqli_query($conn, $sqlupdatestock);
                echo $row["stock"] - $quantity;
                exit();
            }
        }
    }
    // 2. Remove from cart
    if (isset($_GET["orderid"])) {
        $id = $_GET["orderid"];

        $sqlgetorder = "SELECT quantity,pid FROM tbcart WHERE orderid = $id";
        $resultgetorder = mysqli_query($conn, $sqlgetorder);
        $rowgetorder = mysqli_fetch_assoc($resultgetorder);
        $productid = $rowgetorder["pid"];
        $quantity = $rowgetorder["quantity"];

        $sqlupdatestock = "UPDATE tbproduct SET stock = stock + $quantity WHERE id = $productid";

        $sqlremove = "DELETE FROM tbcart WHERE orderid=$id";
        if (mysqli_query($conn, $sqlremove)) {
            if (mysqli_query($conn, $sqlupdatestock)) {
                echo "Product removed from cart.";
            } else {
                http_response_code(500);
                echo "Failed to update product in stock.";
            }
        } else {
            http_response_code(500);
            echo "Failed to remove product from cart.";
        }
        exit();
    }

    exit();
} else {
    http_response_code(403);
    die("You are not logged in.");
}
