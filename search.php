<?php

$conn = new mysqli("localhost", "root", "", "medpointdb");
if ($conn->connect_error) {
    die("Connection failed: ");
}
if (isset($_GET["query"])) {
    $searchQuery = $_GET["query"];
    $sql = "SELECT * FROM tbproduct WHERE name LIKE '%$searchQuery%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='grid pb-4 border-b-2 border-gray-500 mb-4 gap-6 grid-cols-1 xl:grid-cols-4 sm:grid-cols-2'>
    <h1 class='font-semibold text-xl col-span-full'>search result..</h1>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<a href='item.php?id=" .
                $row["id"] .
                "'><div class='flex bg-white rounded-md flex-col w-[10rem] items-start shadow-lg '>
    <img src=" .
                $row["image_path"] .
                " class='p-4 transition-all ease-in-out grayscale hover:grayscale-0 aspect-square w-full border-b-2 border-bdr-ash' alt='item'>
    <div class='p-4 flex h-25 overflow-hidden flex-col gap-2'>
    <strong>$ " .
                $row["price"] .
                "</strong>
    <p>" .
                $row["name"] .
                "</p>
    </div>
    </div></a>";
        }
        echo "</div>";
    } else {
        echo "0 results";
    }
}
