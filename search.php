<div class="animate-fadeIn" >
<?php
$conn = new mysqli("localhost", "root", "", "medpoint");
if ($conn->connect_error) {
    die("Connection failed: ");
}
if (isset($_GET["query"])) {
    $relatedQuery = $_GET["query"];
    $sql = "SELECT * FROM inventory join seller on inventory.seller_id = seller.seller_id JOIN products ON inventory.product_id = products.product_id WHERE name LIKE '%$relatedQuery%' OR shop_name LIKE '%$relatedQuery%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) { ?>
    <h3 class='font-extrabold text-[#333] text-3xl col-span-full'>
        Search Results...
    </h3>
    <div class="grid gap-6 mt-7  mx-auto w-full grid-cols-1 md:grid-cols-4 sm:grid-cols-3 ">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class='flex bg-white rounded-xl transition-all ease-in-out duration-500 hover:-translate-y-1 flex-col items-start shadow-[0_2px_8px_rgba(0,0,0,0.08)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.15)]'>
                <div class='h-[200px] relative w-full bg-[#f5f5f5] flex justify-center items-center'>
                    <?php if ($row["stock"] > 0) { ?>
                    <div class="absolute right-2 top-2 bg-[#4CAF50] text-white text-xs font-semibold px-2 py-1 rounded-full">In Stock</div>
                    <?php } else { ?>
                    <div class="absolute right-2 top-2 bg-[#FF5722] text-white text-xs font-semibold px-2 py-1 rounded-full">Out of Stock</div>
                    <?php } ?>
                    <img class="h-28 w-28" src="<?php echo $row[
                        "image_url"
                    ]; ?>" alt='item'>
                </div>
                <div class='p-4 overflow-hidden flex w-full flex-col gap-2'>
                    <p class="text-[#333] overflow-hidden font-semibold">
                        <?php echo $row["name"]; ?>
                    </p>
                    <div class="flex border-t border-[#eee] pt-2 items-center justify-between">
                    <p class="text-[#00796b] text-2xl font-extrabold">
                        Rs. <?php echo $row["unit_price"]; ?>
                    </p>
                    <button class="bg-[#00bFA5] text-white transition-all font-semibold hover:bg-[#00897b] hover:scale-105 px-4 rounded-md py-2" onclick="item(<?php echo $row[
                        "seller_id"
                    ]; ?>, <?php echo $row["product_id"]; ?>)"
                    >🛒 Add</button>
                    </div>
                </div>
            </div>
            <?php } ?>
    </div>
        <?php } else { ?>
            <h3 class='font-extrabold text-[#333] text-3xl col-span-full'>
                No Results...
            </h3>
            <?php }
}
?>
</div>
