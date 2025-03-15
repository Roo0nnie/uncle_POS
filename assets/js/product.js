function calculateSellingPrice() {
  // Get input values
  let origPrice =
    parseFloat(document.querySelector('input[name="orig_price"]').value) || 0;
  let vatPercentage =
    parseFloat(document.querySelector('input[name="vat_price"]').value) || 0;

  // Calculate VAT amount
  let vatAmount = (origPrice * vatPercentage) / 100;
  let sellingPrice = origPrice + vatAmount;

  // Display result
  document.querySelector('input[name="price"]').value = sellingPrice.toFixed(2);
}

document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelector('input[name="orig_price"]')
    .addEventListener("input", calculateSellingPrice);
  document
    .querySelector('input[name="vat_price"]')
    .addEventListener("input", calculateSellingPrice);
});

// Initial received date:
const today = new Date().toISOString().split("T")[0];
document.getElementById("receivedDate").value = today;
