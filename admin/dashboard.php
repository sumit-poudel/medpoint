<?php 
$conn=mysqli_connect("localhost","root","","medpoint");
session_start();
if (!isset($_SESSION["username"])) {
    echo "<script>window.location.href = '/medpoint/login.php?type=admin';</script>";
    exit();
}
if ($_SESSION["level"] != 1) {
    echo "<script>window.location.href = '/medpoint/index.php';</script>";
    exit();
}
$sql="SELECT * FROM `seller` WHERE approval=0;";
$result=mysqli_query($conn,$sql);
?>

<?php include "../header.php"; ?>
<body>
  <?php include "../nav.php"; ?>
<div class="w-full p-6" >

  <div class=" max-w-[1200px] mx-auto shadow-md bg-white rounded-lg p-4">
    <h1 class="text-3xl font-bold mb-4 text-[#333]">Admin Dashboard </h1>
    <div>
<?php if(mysqli_num_rows($result)>0){?>
   
    <div class="grid grid-cols-[100px_1fr_auto] gap-5 border-2 border-[#eee] p-6 rounded-xl transition-all hover:border-[#00bfa5] hover:shadow-lg">
                                                    <div class="w-24 h-24 bg-[#f5f5f5] rounded-lg flex items-center justify-center p-5">
                                                        <img class="aspect-square h-14" src=""
                                                      />
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="font-semibold text-xl color-[#333] mb-2">
                                                          Shop Name
                                                        </div>
                                        
                                                        <div class="text-sm font-semibold text-[#666]">registration number: 1234567890
                                                      </div>
                                                    </div>
                                                    <div class="flex  items-end gap-3">
                                                  
                                                        <button class=" px-6 py-2 text-white cursor-pointer rounded-md text-sm transition-all
                                                            bg-[#00bfa5] active:bg-[#00897b] hover:text-white hover:font-semibold hover:-translate-y-1"
                                                            onclick="removeFromCart(
                                                          )" >✔ Approve</button>

                                                          <button class="px-6 py-2 text-white cursor-pointer rounded-md text-sm transition-all
                                                            bg-orange-500 active:bg-orange-900 hover:font-semibold hover:-translate-y-1"
                                                            onclick="removeFromCart(
                                                          )" >❌ Deny</button>
                                                    </div>
                                                </div>
                            
<?php
  }
  ?>
  </div>
   </div>
</div>
  
      <script src="<?php echo BASE_URL; ?>/public/js/nav.js" ></script>
</body>

</html>
