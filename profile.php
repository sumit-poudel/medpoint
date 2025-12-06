<?php
session_start();
$conn = new mysqli("localhost", "root", "", "medpoint");
if ($conn->connect_error) {
    die("Connection failed: ");
}
if (isset($_GET["q"])) {
    $qry = $_GET["q"];
    if (!isset($_SESSION["username"])) { ?>
        <div class='bg-white shadow-md rounded-2xl w-full'>
                               <div class="p-7 border-b border-[#eee] flex justify-between items-center">
                                   <h1 class="text-2xl font-bold text-[#333]">Shopping Cart</h1>
                                   <button class="px-5 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all bg-[#f5f5f5] hover:bg-[#e0e0e0] text-[#555]" onclick="window.location.href='index.php'">🏠 Continue Shopping</button>
                               </div>
                               <div class="p-8">
                                   <div class="text-center p-y[80px] px-5" >
                                       <p class="text-3xl text-[#333] font-semibold" >No orders Yet</p>
                                   </div>
                               </div>
                           </div>
        <?php exit();}
    $user_id = $_SESSION["user_id"];
    $querycart = "SELECT name,description,image_url,unit_price,number,cart_id,unit_price FROM cart JOIN inventory ON inventory.inventory_id = cart.inventory_id JOIN products ON products.product_id = inventory.product_id WHERE user_id = '$user_id'";
    $querydelivered = "SELECT o.order_id, o.order_date, p.name AS product_name, i.image_url, oi.quantity, i.unit_price, (oi.quantity * i.unit_price) AS total_price, i.seller_id FROM orders o JOIN order_items oi ON o.order_id = oi.order_id JOIN inventory i ON oi.product_id = i.product_id AND oi.seller_id = i.seller_id JOIN products p ON i.product_id = p.product_id WHERE o.buyer_id = '$user_id' ORDER BY o.order_date DESC, o.order_id DESC";
    $resultcart = mysqli_query($conn, $querycart);
    $resultdelivered = mysqli_query($conn, $querydelivered);
    switch ($qry) { case "profile": ?>
        <div class="content-body">
            <form class="profile-form">
                <div class="form-section">
                    <h3 class="form-section-title">Personal Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-input" value="bimal" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-input" value="bimal@example.com">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input" value="Bimal Rana Magar">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-input" value="+977-9800000000">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-input" value="1995-05-15">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <select class="form-input">
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                                <option>Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Address Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="form-input" value="Thamel, Kathmandu">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" class="form-input" value="Kathmandu">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Province</label>
                            <select class="form-input">
                                <option>Bagmati</option>
                                <option>Gandaki</option>
                                <option>Lumbini</option>
                                <option>Koshi</option>
                                <option>Madhesh</option>
                                <option>Karnali</option>
                                <option>Sudurpashchim</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-input" value="44600">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-input" value="Nepal" disabled>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
            <?php break;case "address": ?>
            <div class='w-full h-full flex justify-center items-center'>
                become a seller
            </div>
            <?php break;case "orders":
            if (mysqli_num_rows($resultcart) > 0) { ?>
                <div class='bg-white shadow-md rounded-2xl w-full'>
                    <div class="p-7 border-b border-[#eee] flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-[#333]">Shopping Cart</h1>
                        <button class="px-5 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all bg-[#f5f5f5] hover:bg-[#e0e0e0] text-[#555]" onclick="window.location.href='index.php'">🏠 Continue Shopping</button>
                    </div>
                    <div class="p-8">
                        <div class="cart-items flex flex-col gap-5 mb-7">
                           <?php
                           $total = 0;
                           while ($row = mysqli_fetch_assoc($resultcart)) {
                               $total += $row["unit_price"] * $row["number"]; ?>
                                                <div class="grid grid-cols-[100px_1fr_auto] gap-5 border-2 border-[#eee] p-6 rounded-xl transition-all hover:border-[#00bfa5] hover:shadow-lg">
                                                    <div class="w-24 h-24 bg-[#f5f5f5] rounded-lg flex items-center justify-center p-5">
                                                        <img class="aspect-square h-14" src="<?php echo $row[
                                                            "image_url"
                                                        ]; ?>"/>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="font-semibold text-xl color-[#333] mb-2"><?php echo $row[
                                                            "name"
                                                        ]; ?></div>
                                                        <div class="text-sm font-semibold mb-2 text-[#666]"><?php echo $row[
                                                            "description"
                                                        ]; ?></div>
                                                        <div class="text-sm font-semibold text-[#666]">quantity: <?php echo $row[
                                                            "number"
                                                        ]; ?></div>
                                                    </div>
                                                    <div class="flex flex-col items-end gap-3">
                                                        <div class="text-3xl font-bold text-[#00796b]">Rs. <?php echo $row[
                                                            "unit_price"
                                                        ]; ?></div>
                                                        <button class="bg-[#ffebee] px-6 py-2 text-red-500 cursor-pointer rounded-md text-sm transition-all
                                                            hover:bg-red-500 hover:text-white hover:font-semibold hover:-translate-y-1"
                                                            onclick="removeFromCart(event,<?php echo $row[
                                                                "cart_id"
                                                            ]; ?>)" >🗑️ Remove</button>
                                                    </div>
                                                </div>
                                                <?php
                           }
                           ?>
                                            </div>
                                            <div class="max-w-[350px] ml-auto">
                                                <div class="bg-[#f8f9fa] p-7 rounded-xl border-2 border-[#e0e0e0]">
                                                    <div class="text-xl font-bold mb-5 text-[#333]">Order Summary</div>
                                                    <div class="flex justify-between mb-3 text-base text-[#555]">
                                                        <span>Total Amount</span>
                                                        <span>Rs. <?php echo number_format(
                                                            $total,
                                                            2,
                                                        ); ?></span>
                                                    </div>

                                                    <button onclick="deliverComponent()" class="w-full text-white mt-2 rounded-lg font-semibold text-lg py-3 bg-orange-500 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all hover:bg-orange-600">
                                                        🛍️ Proceed to Checkout
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                </div>
                <?php } else { ?>
                    <div class='bg-white shadow-md rounded-2xl w-full'>
                        <div class="p-7 border-b border-[#eee] flex justify-between items-center">
                            <h1 class="text-2xl font-bold text-[#333]">Shopping Cart</h1>
                            <button class="px-5 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all bg-[#f5f5f5] hover:bg-[#e0e0e0] text-[#555]" onclick="window.location.href='index.php'">🏠 Continue Shopping</button>
                        </div>
                        <div class="p-8">
                            <div class="text-center p-y[80px] px-5" >
                                <p class="text-3xl text-[#333] font-semibold" >No orders Yet</p>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php }
            break;

        case "delivered":
            if (mysqli_num_rows($resultdelivered) > 0) {

                $data = [];
                while ($row = mysqli_fetch_assoc($resultdelivered)) {
                    $order_id = $row["order_id"];
                    $data["$order_id"][] = $row;
                }
                ?>
                <div class='bg-white shadow-md rounded-2xl w-full'>
                    <div class="p-7 border-b border-[#eee] flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-[#333]">Delivered Orders</h1>
                        <button class="px-5 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all bg-[#f5f5f5] hover:bg-[#e0e0e0] text-[#555]" onclick="window.location.href='index.php'">🏠 Continue Shopping</button>
                    </div>
                    <div class="p-8">
                        <div class= "flex flex-col gap-3" >
                               <?php foreach ($data as $order_id => $orders) {

                                   // Get date from first item
                                   $order_date = $orders[0]["order_date"];
                                   // Initialize total variable for each order
                                   $total = 0;
                                   ?>
                                   <div class='bg-white border-2 overflow-hidden border-[#eee] transition-all  hover:border-[#00bfa5] hover:shadow-[0_8px_24px_rgba(0,191,165,0.15)] rounded-2xl w-full'>
                                       <div class="p-7 bg-[#f8f9fa] border-b border-[#eee]">
                                           <div class="grid grid-cols-[150px_1fr_auto] gap-6">
                                                <div class="flex flex-col gap-1">
                                                    <span class="font-semibold text-xs text-[#999]">Order ID</span>
                                                    <span class="bg-[#00bfa5] text-white py-1 px-3 rounded-md font-bold"><?php echo $order_id; ?></span>
                                                </div>
                                                <div class="flex flex-col flex-1 gap-1">
                                                    <span class="font-semibold text-xs text-[#999]">Order Date</span>
                                                    <span class="font-semibold text-base"><?php echo $order_date; ?></span>
                                                </div>
                                                <div>
                                                    <span class="rounded-full bg-[#e8f5e9] text-[#00bfa5] py-1 px-3 font-bold">
                                                        ✓ Delivered
                                                    </span>
                                                </div>
                                           </div>
                                       </div>
                                  <?php foreach (
                                      $orders
                                      as $index => $order
                                  ) { ?>
                                      <div class="flex flex-col p-6 gap-2" >
                                      <div class="grid grid-cols-[100px_1fr_auto] gap-5 p-6 bg-[#f9f9f9] hover:bg-[#f0f0f0] transition-all rounded-xl">
                                          <div class="w-24 h-24 bg-white shadow-md rounded-lg flex items-center justify-center p-5">
                                              <img class="aspect-square h-14" src="<?php echo $order[
                                                  "image_url"
                                              ]; ?>"/>
                                          </div>
                                          <div class="flex-1">
                                              <div class="font-semibold text-xl color-[#333] mb-2"><?php echo $order[
                                                  "product_name"
                                              ]; ?></div>
                                              <div class="text-sm font-semibold text-[#666]">quantity: <?php echo $order[
                                                  "quantity"
                                              ]; ?></div>
                                          </div>
                                          <div class="flex flex-col items-end gap-3">
                                              <div class="text-3xl font-bold text-[#00796b]">Rs. <?php echo $order[
                                                  "unit_price"
                                              ]; ?></div>
                                              <div class="bg-white px-6 py-2 text-[#666] cursor-pointer rounded-md text-sm transition-all
                                                  hover:bg-red-500 hover:text-white hover:font-semibold hover:-translate-y-1">
                                                      total: Rs. <?php
                                                      $total +=
                                                          $order["unit_price"] *
                                                          $order["quantity"];
                                                      echo $total;
                                                      ?>
                                                  </div>
                                          </div>
                                      </div>
                                      </div>
                                      <?php } ?>
                                      <div class="p-7 border-t border-[#eee] bg-[#f8f9fa] flex justify-between items-center">
                                          <div class="flex flex-col">
                                              <span class="font-semibold text-xs text-[#999]">Total Amount</span>
                                              <p class="text-[#00796b] font-bold text-3xl" > Rs.
                                                <?php echo $total; ?>
                                              </p>
                                          </div>
                                      </div>
                                   </div>
                             <?php
                               } ?>
                        </div>
                    </div>
                </div>
                               <?php
            } else {
                 ?>
                           <div class='bg-white shadow-md rounded-2xl w-full'>
                                                  <div class="p-7 border-b border-[#eee] flex justify-between items-center">
                                                      <h1 class="text-2xl font-bold text-[#333]">Delivered Orders</h1>
                                                      <button class="px-5 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all bg-[#f5f5f5] hover:bg-[#e0e0e0] text-[#555]" onclick="window.location.href='index.php'">🏠 Continue Shopping</button>
                                                  </div>
                                                  <div class="p-8">
                                                      <div class="text-center p-y[80px] px-5" >
                                                          <p class="text-3xl text-[#333] font-semibold" >No delivered Yet</p>
                                                      </div>
                                                  </div>
                                              </div>
                           </div>
                               <?php
            }
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
    <nav class="z-[40] bg-ash shadow-md sticky top-0">
      <div class="flex max-w-[1200px] mx-auto w-full flex-wrap items-center justify-between p-3">
        <a href="index.php" class="flex items-center space-x-3">
          <img src="./public/med-logo.png" class="h-8" alt="Logo" />
          <h1 class="self-center whitespace-nowrap font-bold text-2xl text-[#00bfa5] ">med<bold class="text-[#00796b]" >point</bold></h1>
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
          <button type="button" class="text-white bg-[#00bfa5] rounded-full p-1 hover:bg-white hover:text-[#00bfa5]" id="user-menu-button" aria-expanded="false">
              <svg class="h-8 w-8 stroke-current stroke-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
          </button>
          <!-- Dropdown menu -->
          <div class="z-50 hidden min-w-32 text-start absolute top-5 right-0  my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
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
                <?php if (isset($_SESSION["username"])) {
                    echo "<li>
                    <a href='profile.php' class='block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white'>cart</a>
              </li>";
                    echo "<li>
                    <a href='/medpoint/logout.php' class='block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white'>
                      sign out
                  </a>";
                } else {
                    echo "<a href='/medpoint/login.php?type=user' class='block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white'>
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
        <section class="w-full px-2 mt-6" >
            <div class="max-w-[1200px] mx-auto flex gap-8" >
                <div class="bg-white rounded-2xl sticky shadow-md w-[280px] top-[90px] self-start">
                    <div class="flex flex-col px-8 py-6 justify-center items-center border-b border-[#eee] gap-2">
                        <div class=" bg-[radial-gradient(circle_at_top_left,_#20e3b2,_#0d9488)]
                            rounded-full h-20 w-20 flex justify-center mb-2 items-center">
                            <svg class="stroke-white stroke-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </div>
                        <div class="text-nowrap text-lg text-[#333] font-semibold">
                          <?php if (isset($_SESSION["fullname"])) {
                              echo $_SESSION["fullname"];
                          } else {
                              echo "Guest Kumar";
                          } ?>
                        </div>
                        <div class="text-nowrap text-[#333] font-light">
                          <?php if (isset($_SESSION["username"])) {
                              echo $_SESSION["username"];
                          } else {
                              echo "Guest";
                          } ?>
                        </div>
                    </div>
                    <div class="py-5" >
                        <div class="text-nowrap text-[#999] px-3 font-light">
                            Account
                        </div>
                        <div>
                            <ul class="text-[#555]" >
                                <li class="hover:bg-[#f5f5f5] border-l-2 border-transparent hover:border-[#00bfa5] transition-all hover:text-[#00796b]" ><button class="px-6 py-[12px]" id="profile"><span>👤</span> Edit Profile</button></li>
                                <li class="hover:bg-[#f5f5f5] border-l-2 border-transparent hover:border-[#00bfa5] transition-all hover:text-[#00796b]" ><button class="px-6 py-[12px]" id="address"><span>💊</span> Become a Seller</button></li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="text-nowrap text-[#999] px-3 font-light">
                                               Orders
                        </div>
                        <div>
                            <ul class="text-[#555]" >
                                <li class="hover:bg-[#f5f5f5] border-l-2 border-transparent hover:border-[#00bfa5] transition-all hover:text-[#00796b]" ><button class="px-6 py-[12px]" id="orders"><span>🛒</span> Orders</button></li>
                                <li class="hover:bg-[#f5f5f5] border-l-2 border-transparent hover:border-[#00bfa5] transition-all hover:text-[#00796b]" ><button class="px-6 py-[12px]" id="delivered"><span>📦</span> Shipped</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="py-5" >
                        <div>
                            <ul class="text-[#555]" >
                                <li class="hover:bg-[#f5f5f5] border-l-2 border-transparent hover:border-[#00bfa5] transition-all hover:text-[#00796b] py-3 " ><a class="px-6" href="logout.php"><span>🚪</span> log out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="profileContent" class="w-full min-h-screen"></div>
            </div>
        </section>
    </main>
    <script src="public/js/profile.js"></script>
    <script src="public/js/nav.js"></script>
</body>
