<?php
session_start();
$conn = new mysqli("localhost", "root", "", "medpointdb");
if (isset($_GET["username"])) {
    $username = $_GET["username"];
    $qry = "SELECT * FROM tbuser WHERE username = '$username'";
    $result = mysqli_query($conn, $qry);
    if (mysqli_num_rows($result) > 0) {
        echo "taken";
    } else {
        echo "available";
    }
    mysqli_close($conn);
    exit();
}
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $confirmpassword = $_POST["confirmpassword"];
    $conn = new mysqli("localhost", "root", "", "medpointdb");
    $qry = "SELECT * FROM tbuser WHERE username = '$username'";
    $result = mysqli_query($conn, $qry);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('title').innerText='Username not avaliable!';
    document.getElementById('usernameBox').classList.add('border-red-500');
  });
</script>
";
    } else {
        $sql = "INSERT INTO tbuser (username, fullname, phone, password) VALUES ('$username', '$fullname','$phone' ,'$password')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION["username"] = $username;
            $_SESSION["fullname"] = $fullname;
            setcookie("username", $username, time() + 86400 * 30, "/");
            echo "<script>window.location.href = '/medpoint'</script>";
        } else {
            echo "<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('title').innerText='error';
  });
</script>
";
        }
    }
    mysqli_close($conn);
}
?>

<!-- form body -->

<?php include "header.php"; ?>
<body>
  <section class=" w-screen h-screen flex flex-col justify-center items-center ">
    <div class="flex h-fit w-fit justify-center m-auto items-center shadow-lg rounded-2xl overflow-hidden ">
      <div class="w-fit p-4 flex flex-col justify-center items-center ">
        <img src="./public/med-logo.png" class="-rotate-15 aspect-auto max-w-30 " alt="logo">
        <h2 class="font-heading font-bold text-2xl text-main-black mt-4 ">Connect with us</h2>
        <p>MedPoint — Your Trusted Pharmacy, Online.</p>
      </div>
      <div class="p-4 border-l-2 w-[30vw] border-main-gray ">
        <h3 id="title" class="self-start font-heading font-bold text-lg text-main-black ">Create:</h3>
        <form action="" method="post" class="flex flex-col justify-start  p-2 ">
          <fieldset id="usernameBox" class="rounded-lg border-main-gray h-15 pl-3 border-2">
            <legend class="text-main-black ml-2 font-heading font-semibold ">UserName*</legend>
            <label  class=" flex text-main-gray items-center gap-1.5">
              <img src="./public/person.svg" class="h-4 w-4" alt="person icon" /> |
              <input id="username" type="text" name="username" class=" w-full focus:outline-0 font-semibold focus:text-main-black placeholder-main-gray placeholder:font-heading placeholder:font-semibold " required placeholder="Enter your user name" />
            </label>
          </fieldset>
          <p class="text-red-500 " id="userError" ></p>
          <fieldset id="fullnameBox" class="rounded-lg border-main-gray h-15 pl-3 border-2">
            <legend class="text-main-black ml-2 font-heading font-semibold ">FullName*</legend>
            <label class=" flex text-main-gray items-center gap-1.5">
              <img src="./public/person.svg" class="h-4 w-4" alt="person icon" /> |
              <input id="fullname" type="text" name="fullname" class=" w-full focus:outline-0 font-semibold focus:text-main-black placeholder-main-gray placeholder:font-heading placeholder:font-semibold " required placeholder="Enter your full name" />
            </label>
          </fieldset>
          <p class="text-red-500" id="nameError" ></p>
          <fieldset id="phoneBox" class="rounded-lg border-main-gray h-15 pl-3 border-2">
            <legend class="text-main-black ml-2 font-heading font-semibold ">Phone*</legend>
            <label  class=" flex text-main-gray items-center gap-1.5">
              <img src="./public/person.svg" class="h-4 w-4" alt="person icon" /> |
              <input id="phone" type="text" name="phone" class=" w-full focus:outline-0 font-semibold focus:text-main-black placeholder-main-gray placeholder:font-heading placeholder:font-semibold " required placeholder="Enter your phone number" />
            </label>
          </fieldset>
          <p class="text-red-500" id="phoneError" ></p>
          <fieldset id="passwordBox" class="rounded-lg border-main-gray h-15 pl-3 border-2">
            <legend class="text-main-black ml-2 font-heading font-semibold ">Password*</legend>
            <label class=" flex text-main-gray items-center gap-1.5">
              <img src="./public/person.svg" class="h-4 w-4" alt="person icon" /> |
              <input id="password" type="password" name="password" class=" w-full focus:outline-0 font-semibold focus:text-main-black placeholder-main-gray placeholder:font-heading placeholder:font-semibold " required placeholder="password" />
            </label>
          </fieldset>
          <p class="text-red-500" id="passError"></p>
          <fieldset id="confirmpasswordBox" class="rounded-lg border-main-gray h-15 pl-3 border-2">
            <legend class="text-main-black ml-2 font-heading font-semibold ">ConfirmPassword*</legend>
            <label class=" flex text-main-gray items-center gap-1.5">
              <img src="./public/person.svg" class="h-4 w-4" alt="person icon" /> |
              <input id="confirmpassword" type="password" name="confirmpassword" class=" w-full focus:outline-0 font-semibold focus:text-main-black placeholder-main-gray placeholder:font-heading placeholder:font-semibold " required placeholder="confirm password" />
            </label>
          </fieldset>
          <hr class=" border-1 my-6 border-main-gray">
          <button
            type="submit"
            id="submit"
            name="submit"
            class="w-full hover:cursor-pointer p-2 font-semibold rounded-md bg-blue-500 text-white text-center ">
            create an account
          </button>
        </form>
      </div>
    </div>
  </section>
  <script src="public/js/create.js"></script>
</body>
