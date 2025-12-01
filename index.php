<?php
define("BASE_URL", "http://localhost/medpoint"); ?>

<?php include "header.php"; ?>
<body>
  <?php include "navbar.php"; ?>
  <section class="bg-[url('./public/background.jpg')] bg-cover bg-center h-64 flex flex-col justify-center items-center text-white font-bold text-3xl">
    <h1 class="w-full pl-[10%] text-start">Nepal largest <br>e-pharmaceutical company </h1>
  </section>
  <main class=" m-4 h-fit flex flex-col items-center">
    <div id="searchResult"></div>
    <?php include "items.php"; ?>
    <div class="fixed bottom-10 right-10 w-12 h-12">
        <a href="profile.php" class="relative hover:cursor-pointer">
        <img class="w-full h-full rounded-full bg-white shadow-md p-2" src="./public/cart.svg" alt="">

        <strong id="cart" class="absolute -top-2 -right-2 bg-red-500 text-white text-sm w-6 h-6 flex items-center justify-center rounded-full">
            0
        </strong>
        </a>
    </div>
  </main>
  <?php include "footer.php"; ?>
