
jQuery(document).ready(function () {


    const dropdownButton = document.getElementById("dropdown-button");
    const dropdownMenu = document.getElementById("dropdown-menu");
    const dropdownSelectedOption = document.getElementById("dropdown-selected-option");
    const caret = document.getElementById("caret");

    function toggleCaret() {
        caret.style.transform == 'rotate(0deg)' ? caret.style.transform = 'rotate(180deg)' : caret.style
            .transform = 'rotate(0deg)';
    }

    dropdownButton.addEventListener("click", function (event) {
        event.stopPropagation();

        toggleCaret();
        dropdownMenu.classList.toggle("hidden");
        dropdownButton.setAttribute("aria-expanded", dropdownMenu.classList.contains("hidden") ?
            "false" : "true");
    });

    // Add placeholder text to list items
    const dropdownItems = dropdownMenu.querySelectorAll("[role='menuitem']");
    dropdownItems.forEach(function (item) {
        item.addEventListener("click", function (event) {
            event.preventDefault();
            dropdownSelectedOption.textContent = item.textContent;
            dropdownMenu.classList.add("hidden");
            dropdownButton.setAttribute("aria-expanded", "false");
            toggleCaret();

        });
    });

    // Dismiss dropdown when clicking outside of it
    document.addEventListener("click", function (event) {
        if (!dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add("hidden");
            dropdownButton.setAttribute("aria-expanded", "false");
            caret.style.transform = 'rotate(0deg)';
        }
    });


})


$(document).ready(function () {

    const dropdownButton = document.getElementById("dropdown-button-login");
    const dropdownMenu = document.getElementById("dropdown-menu-login");
    const dropdownSelectedOption = document.getElementById("dropdown-selected-option-login");
    const caret = document.getElementById("caret-login");
    const dropdownMenuRegistration = document.getElementById("dropdown-menu-registration"); // Reference to dropdown-menu-login

    function toggleCaret() {
        caret.style.transform === 'rotate(0deg)' ? caret.style.transform = 'rotate(180deg)' : caret.style.transform = 'rotate(0deg)';
    }

    dropdownButton.addEventListener("click", function (event) {
        event.stopPropagation();
        if (!dropdownMenuRegistration.classList.contains("hidden")) {
            dropdownMenuRegistration.classList.add("hidden");
        }
        toggleCaret();
        dropdownMenu.classList.toggle("hidden");
        dropdownButton.setAttribute("aria-expanded", dropdownMenu.classList.contains("hidden") ? "false" : "true");
    });

    // Add placeholder text to list items
    const dropdownItems = dropdownMenu.querySelectorAll("button");
    dropdownItems.forEach(function (item) {
        item.addEventListener("click", function (event) {
            event.preventDefault();
            dropdownSelectedOption.textContent = item.textContent;
            dropdownMenu.classList.add("hidden");
            dropdownButton.setAttribute("aria-expanded", "false");
            toggleCaret();
        });
    });

    // Dismiss dropdown when clicking outside of it
    document.addEventListener("click", function (event) {
        if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
            dropdownMenu.classList.add("hidden");
            dropdownButton.setAttribute("aria-expanded", "false");
            caret.style.transform = 'rotate(0deg)';
        }
    });

});


$(document).ready(function () {
    const dropdownButton = document.getElementById("dropdown-button-registration");
    const dropdownMenu = document.getElementById("dropdown-menu-registration");
    const dropdownSelectedOption = document.getElementById("dropdown-selected-option-registration");
    const caret = document.getElementById("caret-registration");

    const dropdownMenuLogin = document.getElementById("dropdown-menu-login"); // Reference to dropdown-menu-login

    function toggleCaret() {
        caret.style.transform === 'rotate(0deg)' ? caret.style.transform = 'rotate(180deg)' : caret.style.transform = 'rotate(0deg)';
    }

    dropdownButton.addEventListener("click", function (event) {
        event.stopPropagation();

        // Hide dropdown-menu-login
        if (!dropdownMenuLogin.classList.contains("hidden")) {
            dropdownMenuLogin.classList.add("hidden");
        }

        toggleCaret();
        dropdownMenu.classList.toggle("hidden");
        dropdownButton.setAttribute("aria-expanded", dropdownMenu.classList.contains("hidden") ? "false" : "true");
    });

    // Add placeholder text to list items
    const dropdownItems = dropdownMenu.querySelectorAll("button");
    dropdownItems.forEach(function (item) {
        item.addEventListener("click", function (event) {
            event.preventDefault();
            dropdownSelectedOption.textContent = item.textContent;
            dropdownMenu.classList.add("hidden");
            dropdownButton.setAttribute("aria-expanded", "false");
            toggleCaret();
        });
    });

    // Dismiss dropdown when clicking outside of it
    document.addEventListener("click", function (event) {
        if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
            dropdownMenu.classList.add("hidden");
            dropdownButton.setAttribute("aria-expanded", "false");
            caret.style.transform = 'rotate(0deg)';
        }
    });
});

