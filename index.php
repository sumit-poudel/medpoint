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
    <?php
    include "items.php";
    include "cart.php";
    ?>
  </main>
  <?php include "footer.php"; ?>
