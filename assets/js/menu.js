// Add order item
function updateStockAndTotal(inputElement, price) {
  let quantity = parseInt(inputElement.value);
  if (isNaN(quantity) || quantity < 0) {
    quantity = 0;
    inputElement.value = quantity;
  }

  let totalCost = 0;

  let allQuantities = document.querySelectorAll(".quantity-input");
  allQuantities.forEach(function (input) {
    let prodQuantity = parseInt(input.value);
    if (!isNaN(prodQuantity)) {
      let prodPrice = parseFloat(input.getAttribute("data-price"));
      if (!isNaN(prodPrice)) {
        totalCost += prodQuantity * prodPrice;
      } else {
        console.error("Invalid price attribute detected for an element.");
      }
    }
  });

  let totalCostElement = document.getElementById("total-cost");
  if (totalCostElement) {
    totalCostElement.value = totalCost.toFixed(2);
  } else {
    console.error("Total cost element not found.");
  }
}

function increaseQuantity(button, stock, price) {
  let quantityInput = button.parentElement.querySelector(".quantity-input");
  let currentQuantity = parseInt(quantityInput.value);

  if (currentQuantity < stock) {
    quantityInput.value = currentQuantity + 1;
    updateStockAndTotal(quantityInput, price);
  }
}

function decreaseQuantity(button, stock, price) {
  let quantityInput = button.parentElement.querySelector(".quantity-input");
  let currentQuantity = parseInt(quantityInput.value);
  if (currentQuantity > 0) {
    quantityInput.value = currentQuantity - 1;
    updateStockAndTotal(quantityInput, price);
  }
}

let orderId = Math.floor(Math.random() * 1000000000);
document.getElementById("order-id").value = orderId;

document.addEventListener("DOMContentLoaded", function () {
  const today = new Date();
  const formattedDate = today.toISOString().split("T")[0];
  document.getElementById("order-date").value = formattedDate;
});

// Condition for payment. Greater than or equal to total amount
document.addEventListener("DOMContentLoaded", function () {
  const totalCost = document.getElementById("total-cost");
  const totalPayment = document.getElementById("total-payment");
  const submitButton = document.querySelector('button[name="submit"]');

  // Function to check payment and update button state
  function checkPayment() {
    const cost = parseFloat(totalCost.value) || 0;
    const payment = parseFloat(totalPayment.value) || 0;

    if (payment < cost) {
      submitButton.disabled = true;
      submitButton.innerHTML = "Insufficient Payment";
      submitButton.classList.remove("btn-primary");
      submitButton.classList.add("btn-danger");
    } else {
      submitButton.disabled = false;
      submitButton.innerHTML = "Submit Order";
      submitButton.classList.remove("btn-danger");
      submitButton.classList.add("btn-primary");
    }
  }

  // Check on page load
  checkPayment();

  // Check whenever payment amount changes
  totalPayment.addEventListener("input", checkPayment);
});

document.addEventListener("DOMContentLoaded", function () {
  // Set date
  const today = new Date();
  const formattedDate = today.toISOString().split("T")[0];
  document.getElementById("order-date").value = formattedDate;

  // Get all tab buttons
  const tabButtons = document.querySelectorAll(".tab-button");

  // Set initial active state (optional)
  tabButtons[0].classList.add("active");
});

function showTab(tabId) {
  // Handle content tabs
  document.querySelectorAll(".tab-content").forEach((tab) => {
    tab.classList.remove("active");
  });
  document.getElementById(tabId).classList.add("active");

  // Handle button colors
  document.querySelectorAll(".tab-button").forEach((button) => {
    button.classList.remove("active");
    button.classList.remove("btn-success");
    button.classList.add("btn-primary");
  });

  // Add active class to clicked button
  event.currentTarget.classList.remove("btn-primary");
  event.currentTarget.classList.add("btn-success");
  event.currentTarget.classList.add("active");
}
