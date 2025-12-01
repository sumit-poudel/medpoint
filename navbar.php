<nav class=" bg-ash z-[40] shadow-md sticky top-0">
  <div class="flex w-full inherit flex-wrap items-center justify-between mx-auto p-4">
    <a href="index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="./public/med-logo.png" class="h-8" alt="Logo" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap">medpoint</span>
    </a>

    <section class="flex items-center rounded-md border-2 border-r-0 h-10 p-0.5 pl-2 border-bdr-ash overflow-visible "
    <label for="search">Search |</label>
    <input id="searchBar" type="text" placeholder="search" value="" class=" focus:outline-0 pl-1 h-10 text-txt-ash">
    <button id="clear" class="px-2">clear</button>
    <button id="searchButton" type="search" class=" hover:cursor-pointer active:bg-med-drklime rounded-md w-10.75 h-10.75 flex justify-center items-center  bg-med-lime text-white font-extrabold  ">
      <img class="h-4 w-4 " src="./public/search.svg" alt="search">
    </button>
    </section>

    <div class="relative flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        <?php if (isset($_SESSION["username"])) {
            echo $_SESSION["username"];
        } ?>
      <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 ring-4 ring-gray-300" id="user-menu-button" aria-expanded="false">
        <span class="sr-only">Open user menu</span>
        <img class="w-8 h-8 rounded-full" src="./public/person.svg" alt="user photo">
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
