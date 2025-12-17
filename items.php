<!-- normal data showw -->
<div class="grid gap-6 mt-0 mx-auto w-full grid-cols-1 md:grid-cols-4 sm:grid-cols-3 ">

    <?php
    $conn = new mysqli("localhost", "root", "", "medpoint");
    if ($conn->connect_error) {
        die("Connection failed: ");
    }
    $sql =
        "SELECT * FROM inventory JOIN products ON inventory.product_id=products.product_id JOIN categories on products.category_id = categories.category_id;";
    $data = [];
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $category = $row["category"];
            $data["$category"][] = $row;
        }
        // data becomes this structure
        //         $data = [
        //   "category" => [
        //     [ "id" => 1, "name" => "Paracetamol" ],
        //     [ "id" => 2, "name" => "Amoxicillin" ]
        //   ],
        //   "category2" => [
        //     [ "id" => 3, "name" => "medss" ]
        //   ]
        // ];

        foreach ($data as $category => $items) { ?>
            <h3 class='font-extrabold text-[#333] text-3xl col-span-full'>
                <?php echo $category; ?>
            </h3>
                <?php foreach ($items as $item) { ?>
                <div class='flex bg-white rounded-xl transition-all ease-in-out duration-500 hover:-translate-y-1 flex-col items-start shadow-[0_2px_8px_rgba(0,0,0,0.08)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.15)]'>
                    <div class='h-[200px] relative w-full bg-[#f5f5f5] flex justify-center items-center'>
                        <?php if ($item["stock"] > 0) { ?>
                        <div class="absolute right-2 top-2 bg-[#4CAF50] text-white text-xs font-semibold px-2 py-1 rounded-full">In Stock</div>
                        <?php } else { ?>
                        <div class="absolute right-2 top-2 bg-[#FF5722] text-white text-xs font-semibold px-2 py-1 rounded-full">Out of Stock</div>
                        <?php } ?>
                        <img class="h-28 w-28" src="<?php echo $item[
                            "image_url"
                        ]; ?>" alt='item'>
                    </div>
                    <div class='p-4 overflow-hidden flex w-full flex-col gap-2'>
                        <p class="text-[#333] overflow-hidden font-semibold"><?php echo $item[
                            "name"
                        ]; ?></p>
                        <div class="flex border-t border-[#eee] pt-2 items-center justify-between">
                        <p class="text-[#00796b] text-2xl font-extrabold">Rs. <?php echo $item[
                            "unit_price"
                        ]; ?></p>
                        <button class="bg-[#00bFA5] text-white transition-all font-semibold hover:bg-[#00897b] hover:scale-105 px-4 rounded-md py-2" onclick="item(<?php echo $item[
                            "seller_id"
                        ]; ?>, <?php echo $item["product_id"]; ?>)"
                        >🛒 Add</button>
                        </div>
                    </div>
                </div>
                <?php }}
        mysqli_close($conn);
    } else {
        echo "0 results";
    }
    ?>
</div>
