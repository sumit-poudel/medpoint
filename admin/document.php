<?php

define("BASE_URL", "http://localhost/medpoint");
$conn = mysqli_connect("localhost", "root", "", "medpoint");

if (isset($_GET["id"]) && isset($_GET["action"])) {
    $action = $_GET["action"];
    $id = $_GET["id"];
    switch ($action) {
        case "accept":
            $sql = "UPDATE seller SET approval = 1 WHERE seller_id = $id";
            if (mysqli_query($conn, $sql)) {
                http_response_code(200);
            } else {
                http_response_code(500);
            }
            break;
        case "reject":
            $sql = "DELETE FROM seller WHERE seller_id = $id";
            if (mysqli_query($conn, $sql)) {
                http_response_code(200);
            } else {
                http_response_code(500);
            }
            break;
        default:
            break;
    }
    exit();
} elseif (isset($_GET["id"])) {

    $id = $_GET["id"];
    $sql = "SELECT document_path from seller WHERE seller_id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <img class="h-full" src="<?php echo BASE_URL .
        "/" .
        $row["document_path"]; ?>"/>
<?php exit();
}
?>
