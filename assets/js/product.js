function calculateSellingPrice() {
  // Get input values
  let origPrice =
    parseFloat(document.querySelector('input[name="orig_price"]').value) || 0;
  let vatPercentage =
    parseFloat(document.querySelector('select[name="vat_price"]').value) || 0;

  console.log(vatPercentage);

  // Calculate VAT amount
  let vatPercents = vatPercentage / 100;
  console.log(vatPercents);
  let vatAmount = (origPrice * vatPercentage) / 100;
  console.log(vatAmount);
  let sellingPrice = origPrice + vatAmount;

  // Display result
  document.querySelector('input[name="price"]').value = sellingPrice.toFixed(2);
}

document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelector('input[name="orig_price"]')
    .addEventListener("input", calculateSellingPrice);
  document
    .querySelector('select[name="vat_price"]')
    .addEventListener("change", calculateSellingPrice);
});

// Set today's date to receivedDate input (if exists)
document.addEventListener("DOMContentLoaded", function () {
  let receivedDateInput = document.getElementById("receivedDate");
  if (receivedDateInput) {
    receivedDateInput.value = new Date().toISOString().split("T")[0];
  }
});
