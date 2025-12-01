<?php
$conn = new mysqli("localhost", "root", "", "medpointdb");

if (isset($_GET["id"]) && isset($_GET["user"])) {
    $user = $_GET["user"];
    $id = $_GET["id"];
    $date = date("Y/m/d");

    $sql = "SELECT * FROM tbcart WHERE username = '$user' AND pid = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $count = $row["count"] + 1;

        $sql = "UPDATE tbcart SET count = $count, buydate = '$date' WHERE username = '$user' AND pid = $id";
        mysqli_query($conn, $sql);

        echo "<script>window.location.href = '/medpoint'</script>";
    } else {
        $sql = "INSERT INTO tbcart (username, pid, count,buydate) VALUES ('$user', $id, 1, '$date')";
        mysqli_query($conn, $sql);
    }
} elseif (isset($_GET["user"])) {
    $user = $_GET["user"];
    $sql = "SELECT * FROM tbcart WHERE username = '$user'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo mysqli_num_rows($result);
    }
} else {
    echo "Invalid request";
}
