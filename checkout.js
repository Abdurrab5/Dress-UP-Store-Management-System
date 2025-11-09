document.addEventListener("DOMContentLoaded", function () {
  const radios = document.getElementsByName("payment_method");
  const instructions = document.getElementById("payment-instructions");

  radios.forEach(radio => {
    radio.addEventListener("change", () => {
      if (radio.checked && radio.value === "JazzCash") {
        instructions.innerText = "Send payment to: 0300-1234567 (JazzCash)";
        instructions.style.display = "block";
      } else if (radio.checked && radio.value === "EasyPaisa") {
        instructions.innerText = "Send payment to: 0321-7654321 (EasyPaisa)";
        instructions.style.display = "block";
      } else {
        instructions.style.display = "none";
      }
    });
  });

  document.getElementById("checkout-form").addEventListener("submit", function () {
    var cart = JSON.parse(localStorage.getItem("cart")) || [];
    document.getElementById("cart_data").value = JSON.stringify(cart);
    // **yahan pe e.preventDefault() nahi lagana!**
    // PHP ko form submit hone do, taki database me save ho
  });
});
