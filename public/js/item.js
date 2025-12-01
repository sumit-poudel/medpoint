const quantity = document.getElementById("quantity");
const stock = document.getElementById("stock");
const remove = document.getElementById("remove");
const add = document.getElementById("add");

remove.addEventListener("click", () => {
  let currentQuantity = parseInt(quantity.innerText);
  if (currentQuantity > 1) {
    quantity.innerText = currentQuantity - 1;
  }
});

add.addEventListener("click", () => {
  let currentQuantity = parseInt(quantity.innerText);
  let currentStock = parseInt(stock.innerText);
  if (currentQuantity < currentStock) {
    quantity.innerText = currentQuantity + 1;
  }
});
