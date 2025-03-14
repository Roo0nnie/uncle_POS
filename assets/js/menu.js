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
    button.classList.remove("card-black");
    button.classList.add("card");
  });

  // Add active class to clicked button
  event.currentTarget.classList.remove("card");
  event.currentTarget.classList.add("card-black");
  event.currentTarget.classList.add("active");
}

// This is for selecting products:
// Global object to store order items
let orderItems = {};

function updateStockAndTotal(inputElement, price) {
  let quantity = parseInt(inputElement.value);
  if (isNaN(quantity) || quantity < 0) {
    quantity = 0;
    inputElement.value = quantity;
  }

  // Get product details
  const productCard = inputElement.closest(".card");
  const productName = productCard.querySelector("h4").textContent;
  const productId = inputElement.getAttribute("name").match(/\[(\d+)\]/)[1];

  // Update order items
  if (quantity > 0) {
    orderItems[productId] = {
      name: productName,
      quantity: quantity,
      price: price,
      total: (quantity * price).toFixed(2),
      inputElement: inputElement, // Store reference to input element
    };
  } else {
    delete orderItems[productId];
  }

  // Update order summary display
  updateOrderSummary();

  // Calculate total cost
  let totalCost = 0;
  let allQuantities = document.querySelectorAll(".quantity-input");
  allQuantities.forEach(function (input) {
    let prodQuantity = parseInt(input.value);
    if (!isNaN(prodQuantity)) {
      let prodPrice = parseFloat(input.getAttribute("data-price"));
      if (!isNaN(prodPrice)) {
        totalCost += prodQuantity * prodPrice;
      }
    }
  });

  let totalCostElement = document.getElementById("total-cost");
  if (totalCostElement) {
    totalCostElement.value = totalCost.toFixed(2);
  }
}

function deleteOrderItem(productId) {
  if (orderItems[productId]) {
    // Reset the quantity input to 0
    orderItems[productId].inputElement.value = "0";
    // Remove item from orderItems
    delete orderItems[productId];
    // Update the display
    updateOrderSummary();
    // Update the total cost
    let totalCost = 0;
    for (const id in orderItems) {
      totalCost += parseFloat(orderItems[id].total);
    }
    let totalCostElement = document.getElementById("total-cost");
    if (totalCostElement) {
      totalCostElement.value = totalCost.toFixed(2);
    }
  }
}

function updateOrderSummary() {
  const selectedProductsDiv = document.getElementById("selected-products");
  selectedProductsDiv.innerHTML = ""; // Clear current summary

  // Create elements for each product in the order
  for (const productId in orderItems) {
    const item = orderItems[productId];
    const productElement = document.createElement("div");
    productElement.className =
      "list-group-item d-flex justify-content-between align-items-center";
    productElement.innerHTML = `
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">${item.name}</h6>
                    <small>$${item.price} × ${item.quantity}</small>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-primary rounded-pill me-2">$${item.total}</span>
                <button class="btn btn-danger btn-sm delete-btn" 
                        onclick="deleteOrderItem('${productId}')" 
                        title="Delete item">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
    selectedProductsDiv.appendChild(productElement);
  }

  // If no items, show message
  if (Object.keys(orderItems).length === 0) {
    selectedProductsDiv.innerHTML =
      '<div class="list-group-item text-center">No items selected</div>';
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
} // Search functionality
document.addEventListener("DOMContentLoaded", function () {
  // Get all search inputs
  const searchInputs = document.querySelectorAll("[id^='searchInput']");

  // Attach event listeners to each search input
  searchInputs.forEach((input) =>
    input.addEventListener("input", filterProducts)
  );
});

function filterProducts(event) {
  // Identify the search input that triggered the event
  const searchInput = event.target;
  const searchSection = searchInput.closest(".row").nextElementSibling; // The product container after the search bar

  const searchTerm = searchInput.value.toLowerCase();
  const products = searchSection.querySelectorAll(".product-card");

  // Loop through each product card
  products.forEach((product) => {
    const productName = product.dataset.name.toLowerCase();

    // Show or hide based on name match
    product.style.display = productName.includes(searchTerm) ? "" : "none";
  });

  // Show "no results" message if no products are visible
  const visibleProducts = Array.from(products).filter(
    (p) => p.style.display !== "none"
  );
  let noResultsMsg = searchSection.querySelector("#no-results-message");

  if (visibleProducts.length === 0) {
    if (!noResultsMsg) {
      const message = document.createElement("div");
      message.id = "no-results-message";
      message.className = "col-12 text-center mt-4";
      message.innerHTML = "<p>No products found matching your search.</p>";
      searchSection.querySelector(".row").appendChild(message);
    }
  } else if (noResultsMsg) {
    noResultsMsg.remove();
  }
}
