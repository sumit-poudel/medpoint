const content = document.getElementById("item-content");
const itemcontainer = document.getElementById("item");

itemcontainer.addEventListener("click", function (e) {
  if (!content.contains(e.target)) {
    closeModal();
  }
});

function ajaxComponent(id) {
  let request = new XMLHttpRequest();
  request.open("GET", "document.php?id=" + id);
  request.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      content.innerHTML = this.responseText;
      content.style.maxHeight = "90vh";
    }
  };
  request.send();
}

function openModal(id) {
  itemcontainer.classList.remove("hidden");
  itemcontainer.classList.add("flex");
  ajaxComponent(id);
}

function closeModal() {
  content.style.maxHeight = "0";
  clearTimeout(timeout);
  timeout = setTimeout(() => {
    itemcontainer.classList.remove("flex");
    itemcontainer.classList.add("hidden");
  }, 700);
}

function accept(id) {
  requestUpdate(id, "accept");
}
function reject(id) {
  requestUpdate(id, "reject");
}

function requestUpdate(id, action) {
  let request = new XMLHttpRequest();
  request.open("GET", "document.php?id=" + id + "&action=" + action);
  request.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      window.location.reload();
    }
  };
  request.send();
}
