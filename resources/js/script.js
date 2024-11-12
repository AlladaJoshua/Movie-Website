document.addEventListener("DOMContentLoaded", function () {
    // Function to toggle the input box on click
    function toggleActive(element) {
      element.classList.toggle("active");
      const input = element.querySelector("input"); // Get the input within the clicked container
      input.classList.toggle("visible-input");
      input.classList.toggle("hidden-input");
      
      if (input.classList.contains("visible-input")) {
        input.focus(); // Focus on input when it's visible
      }
      
      // Event listener to close the input if clicked outside
      document.addEventListener("click", function (event) {
          const inputContainer = document.querySelector(".input-container");
          const input = inputContainer.querySelector("input");

          // Check if the click was outside the inputContainer
          if (!inputContainer.contains(event.target)) {
            inputContainer.classList.remove("active");
            input.classList.add("hidden-input");
            input.classList.remove("visible-input");
          }
        });
    }

    // Attach the toggleActive function to the input-container's onclick event
    const inputContainer = document.querySelector(".input-container");
    if (inputContainer) {
        inputContainer.addEventListener("click", function () {
            toggleActive(inputContainer);
        });
    }
});

window.onload = function() {
  const loader = document.getElementById("loader");
  if (loader) {
      loader.style.display = "flex"; // Show the loader while the page loads

      // Hide the loader once the page is fully loaded
      setTimeout(() => {
          loader.style.display = "none";
      }, 500); // Optional delay to improve UX
  } else {
      console.log("Loader element not found");
  }
};