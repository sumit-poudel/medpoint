<?php
$conn = new mysqli("localhost", "root", "", "medpointdb");

if (isset($_GET["id"]) && isset($_GET["user"]) && isset($_GET["count"])) {
    $user = $_GET["user"];
    $id = $_GET["id"];
    $quantity = $_GET["count"];
    $date = date("Y/m/d");

    $sql = "SELECT * FROM tbcart WHERE username = '$user' AND pid = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $count = $row["count"] + $quantity;

        $sql = "UPDATE tbcart SET count = $count, buydate = '$date' WHERE username = '$user' AND pid = $id";
        mysqli_query($conn, $sql);

        echo "<script>window.location.href = '/medpoint'</script>";
        exit();
    } else {
        $sql = "INSERT INTO tbcart (username, pid, count,buydate) VALUES ('$user', $id, $quantity, '$date')";
        mysqli_query($conn, $sql);
        exit();
    }
} elseif (isset($_GET["user"])) {
    $user = $_GET["user"];
    $sql = "SELECT * FROM tbcart WHERE username = '$user'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo mysqli_num_rows($result);
        exit();
    } else {
        echo 0;
        exit();
    }
} else {
     ?>
    <div class="fixed bottom-10 right-10 w-12 h-12">
        <a href="profile.php" class="relative hover:cursor-pointer">
        <img class="w-full h-full rounded-full bg-white shadow-md p-2" src="./public/cart.svg" alt="">

        <strong id="cart" class="absolute -top-2 -right-2 bg-red-500 text-white text-sm w-6 h-6 flex items-center justify-center rounded-full">
            0
        </strong>
        </a>
    </div>
<?php
} ?>
