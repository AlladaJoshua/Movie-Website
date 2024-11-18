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


document.getElementById('play-button').addEventListener('click', function() {
  const videoElement = document.getElementById('movie-video');
  const playButton = document.getElementById('play-button');
  const backdrop = document.querySelector('.video-backdrop');

  // Play the video
  videoElement.play();

  // Hide the play button and backdrop, make the video visible
  playButton.style.opacity = '0';  // Hide play button
  backdrop.style.opacity = '0';    // Hide the backdrop
  videoElement.style.opacity = '1';  // Ensure the video is visible

  // Ensure video controls are visible
  videoElement.setAttribute('controls', 'true');  // Make sure the controls attribute is present

  // Apply z-index to ensure video controls are above other elements
  videoElement.style.zIndex = '2'; // Make sure video controls are above backdrop and play button
});