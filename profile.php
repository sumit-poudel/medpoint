<?php
session_start();
$conn = new mysqli("localhost", "root", "", "medpointdb");
if ($conn->connect_error) {
    die("Connection failed: ");
}
if (isset($_GET["q"])) {
    $qry = $_GET["q"];
    if (!isset($_SESSION["username"])) { ?>
        <div class='w-full h-full flex justify-center items-center'>";
        <strong class='w-full text-center text-5xl items-center' >log in first</strong>";
        </div>";
        <?php exit();}
    $user = $_SESSION["username"];
    $querycart = "
        SELECT *
        FROM tbproduct
        INNER JOIN tbcart
            ON tbproduct.id = tbcart.pid
        WHERE tbcart.username = '$user'
          AND tbcart.isdelivered = 0
    ";
    $querydelivered = "
            SELECT *
            FROM tbproduct
            INNER JOIN tbcart
                ON tbproduct.id = tbcart.pid
            WHERE tbcart.username = '$user'
              AND tbcart.isdelivered = 1
        ";
    $resultcart = mysqli_query($conn, $querycart);
    $resultdelivered = mysqli_query($conn, $querydelivered);
    switch ($qry) {
        case "profile":
            echo "<section class='flex flex-col w-full h-full gap-2 flex-cols' >";
            echo "<div class='w-full flex gap-4' >";
            echo "<div class='p-4 w-full shadow-md rounded-md bg-white' ><strong>User Name:</strong><br/><em>" .
                $_SESSION["username"] .
                "</em></div>";
            echo "<div class='p-4 w-full shadow-md rounded-md bg-white'><strong>Full Name:</strong><br/><em>" .
                $_SESSION["fullname"] .
                "</em></div>";
            echo "</div>";
            echo "<table class='bg-white table-auto shadow-md rounded-md w-full'>";
            if (mysqli_num_rows($resultcart) > 0) { ?>
                <thead>
                <tr class='border-b text-center' >
                <th class='p-2' >Name</th>
                <th class='p-2' >Image</th>
                <th class='p-2' >Price</th>
                <th class='p-2' >Quantity</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($resultcart)) {
                        echo "<tr class='text-center' >";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td><img class='h-20 mx-auto p-2 aspect-auto' src=" .
                            $row["image_path"] .
                            " /></td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</section>";
                    }
            break;
        case "address": ?>
            <div class='w-full h-full flex justify-center items-center'>
            Address Edit Section
            </div>
            <?php break;case "orders":
            if (mysqli_num_rows($resultcart) > 0) { ?>
                <div class='bg-white table-auto p-4 shadow-md rounded-md w-full'>
                <table class="w-full" >
                <thead>
                <tr class='border-b text-center'>
                <th class='p-2' >Date</th>
                <th class='p-2' >Name</th>
                <th class='p-2' >Image</th>
                <th class='p-2' >Price</th>
                <th class='p-2' >Quantity</th>
                <th class='p-2' ></th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultcart)) {

                    echo "<tr class='text-center' >";
                    echo "<td>" . $row["buydate"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td><img class='h-20 mx-auto p-2 aspect-auto' src=" .
                        $row["image_path"] .
                        " /></td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td>" . $row["quantity"] . "</td>";
                    ?>
                   <td><button onclick="removeFromCart(event,<?php echo $row[
                       "orderid"
                   ]; ?>)" class="p-2 rounded-md active:bg-gray-300 active:text-white" >
                       <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
                       <path d="M 10 2 L 9 3 L 3 3 L 3 5 L 4.109375 5 L 5.8925781 20.255859 L 5.8925781 20.263672 C 6.023602 21.250335 6.8803207 22 7.875 22 L 16.123047 22 C 17.117726 22 17.974445 21.250322 18.105469 20.263672 L 18.107422 20.255859 L 19.890625 5 L 21 5 L 21 3 L 15 3 L 14 2 L 10 2 z M 6.125 5 L 17.875 5 L 16.123047 20 L 7.875 20 L 6.125 5 z"></path>
                       </svg>
                   </button></td>
                    <?php echo "</tr>";
                } ?>
                </tbody>
                </table>
                <div class="p-4 w-full">
                    <button onclick="deliverComponent()" class="w-full p-2 text-lg font-semibold text-white bg-orange-500 active:bg-orange-900 rounded-md" >Buy Now</button>
                </div>
                </div>
                <?php } else { ?>
                    <div class='bg-white flex items-center justify-center p-4 shadow-md rounded-md min-h-[40vh] w-full'>
                    <strong class='my-auto text-center text-xl items-center' >Nothing in cart</strong>
                    </div></div>
                    <?php }
            break;

        case "delivered":
            if (mysqli_num_rows($resultdelivered) > 0) { ?>
                           <div class='bg-white table-auto p-4 shadow-md rounded-md w-full'>
                           <table class="w-full" >
                           <thead>
                           <tr class='border-b text-center'>
                           <th class='p-2' >Date</th>
                           <th class='p-2' >Name</th>
                           <th class='p-2' >Image</th>
                           <th class='p-2' >Price</th>
                           <th class='p-2' >Quantity</th>
                           </tr>
                           </thead>
                           <tbody>
                           <?php while (
                               $row = mysqli_fetch_assoc($resultdelivered)
                           ) {
                               echo "<tr class='text-center' >";
                               echo "<td>" . $row["buydate"] . "</td>";
                               echo "<td>" . $row["name"] . "</td>";
                               echo "<td><img class='h-20 mx-auto p-2 aspect-auto' src=" .
                                   $row["image_path"] .
                                   " /></td>";
                               echo "<td>" . $row["price"] . "</td>";
                               echo "<td>" . $row["quantity"] . "</td>";
                               echo "</tr>";
                           } ?>
                           </tbody>
                           </table>
                           </div>
                           <?php } else { ?>
                               <div class='bg-white flex items-center justify-center p-4 shadow-md rounded-md min-h-[40vh] w-full'>
                               <strong class='my-auto text-center text-xl items-center' >No delivered orders</strong>
                               </div></div>
                               <?php }
            break;
        default:
            echo "Invalid Request";
            break;
    }
    exit();
}
?>


<!-- html code -->
<?php include "header.php"; ?>

<body>
    <!--nav bar-->
    <nav class=" bg-ash z-[40] shadow-md sticky top-0">
        <div class="flex w-full inherit flex-wrap items-center justify-between mx-auto p-4">
            <a href="index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="./public/med-logo.png" class="h-8" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap">medpoint</span>
            </a>

            <div class="relative flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <?php
                session_start();
                if (isset($_SESSION["username"])) {
                    echo "<span class='mr-4'>HOWDEY, " .
                        $_SESSION["username"] .
                        "</span>";
                }
                ?>
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 ring-4 ring-gray-300" id="user-menu-button" aria-expanded="false">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="./public/person.svg" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 min-w-32 text-start hidden absolute top-5 right-0  my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">
                            <?php
                            session_start();
                            if (isset($_SESSION["username"])) {
                                echo $_SESSION["username"];
                            } else {
                                echo "Guest";
                            }
                            ?>
                        </span>
                        <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">
                            <?php if (isset($_SESSION["fullname"])) {
                                echo $_SESSION["fullname"];
                            } else {
                                echo "Welcome to MedPoint";
                            } ?>
                        </span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="index.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Home</a>
                        </li>
                        <li>
                            <?php if (isset($_SESSION["username"])) {
                                echo "<a href='/medpoint/logout.php' class='block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white'>
                  sign out
              </a>";
                            } else {
                                echo "<a href='/medpoint/login.php' class='block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white'>
                sign in
            </a>";
                            } ?>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <main>
        <section class="grid grid-cols-4 w-full mt-4 p-4 gap-4">
            <div class=" bg-ash col-span-1 text-start p-4 h-fit rounded-sm shadow-lg">
                <ul class="space-y-4">
                    <li>
                        <strong class=" text-lg">Manage my account</strong>
                        <ul class="ml-4">
                            <li>
                                <button id="profile">
                                    edit profile
                                </button>
                            </li>
                            <li>
                                <button id="address">
                                    edit address
                                </button>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <strong class="text-lg">
                                My orders
                        </strong>
                        <ul class="ml-4">
                            <li>
                                <button id="orders">
                                Cart
                                </button>
                            </li>
                            <li>
                                <button id="delivered">
                                Delivered
                                </button>
                            </li>
                        </ul>
                    </li>
                    <?php if (isset($_SESSION["level"])) {
                        $level = $_SESSION["level"];
                        switch ($level) {
                            case 1:
                                echo "<li><strong class='text-lg'><a href='/medpoint/admin/dashboard.php'>Dashboard</a></strong></li>";
                                break;
                            case 2:
                                echo "<li><strong class='text-lg'><a href='/medpoint/seller/dashboard.php'>Dashboard</a></strong></li>";
                                break;
                            case 3:
                                echo "";
                                break;
                            default:
                                echo "error";
                                break;
                        }
                    } ?>
                </ul>
            </div>
            <div id="profileContent" class="col-span-3 h-[80vh]"></div>
        </section>
    </main>
    <script src="public/js/profile.js"></script>
    <script src="public/js/nav.js"></script>
</body>
