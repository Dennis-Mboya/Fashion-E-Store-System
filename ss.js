// Get the elements with the IDs 'bar', 'navbar', and 'close'
const bar = document.getElementById('bar');
const nav = document.getElementById('navbar');
const close = document.getElementById('close');

// Check if the 'bar' element exists in the DOM
if (bar) {
    // Add an event listener to 'bar' that triggers when it's clicked
    bar.addEventListener('click', () =>  {
        // Add the 'active' class to the 'navbar' element to show the navigation menu
        nav.classList.add('active');
    });
}

// Check if the 'close' element exists in the DOM
if (close) {
    // Add an event listener to 'close' that triggers when it's clicked
    close.addEventListener('click', () =>  {
        // Remove the 'active' class from the 'navbar' element to hide the navigation menu
        nav.classList.remove('active');
    });
}

// Function to show a popup with a custom message
function showPopup(message) {
    // Get the popup element and the element for the popup message
    var popup = document.getElementById('popup');
    var popupMessage = document.getElementById('popupMessage');

    // Set the text content of the popup message
    popupMessage.textContent = message;

    // Display the popup by setting its display style to 'block'
    popup.style.display = 'block';
}

// Function to close the popup
function closePopup() {
    // Get the popup element
    var popup = document.getElementById('popup');

    // Hide the popup by setting its display style to 'none'
    popup.style.display = 'none';
}
