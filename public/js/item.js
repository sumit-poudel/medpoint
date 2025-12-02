const quantity = document.getElementById("quantity");
const stock = document.getElementById("stock");
const remove = document.getElementById("remove");
const add = document.getElementById("add");
const share = document.getElementById("share");

remove.addEventListener("click", () => {
  let currentQuantity = parseInt(quantity.innerText);
  if (currentQuantity > 1) {
    quantity.innerText = currentQuantity - 1;
  }
});

add.addEventListener("click", () => {
  let currentQuantity = parseInt(quantity.innerText);
  let currentStock = stock.getAttribute("data-stock");
  if (currentQuantity < currentStock) {
    quantity.innerText = currentQuantity + 1;
  }
});

async function shareItem() {
  try {
    await navigator.clipboard.writeText(window.location.href);
    share.classList.remove("border-transparent");
    share.classList.add("share");
  } catch (err) {
    console.error("Could not write to clipboard", err);
  }
}
