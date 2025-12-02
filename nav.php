<?php
define("BASE_URL", "http://localhost/medpoint"); ?>

<nav class=" bg-ash z-[40] shadow-md sticky top-0">
  <div class="flex w-full inherit flex-wrap items-center justify-between mx-auto p-4">
    <a href="<?php echo BASE_URL; ?>/index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="<?php echo BASE_URL; ?>/public/med-logo.png" class="h-8" alt="Logo" />
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
        <img class="w-8 h-8 rounded-full" src="<?php echo BASE_URL; ?>/public/person.svg" alt="user photo">
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
          <li>
              <a href="<?php echo BASE_URL; ?>/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">cart</a>
          </li>
          <li>
            <?php if (isset($_SESSION["username"])) {
                echo "<a href='" .
                    BASE_URL .
                    "/logout.php' class='block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white'>
                  sign out
              </a>";
            } else {
                echo "<a href='" .
                    BASE_URL .
                    "/login.php' class='block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white'>
                sign in
            </a>";
            } ?>
          </li>
        </ul>
      </div>

    </div>
  </div>
</nav>
