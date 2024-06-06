// navbar

document.addEventListener("DOMContentLoaded", function () {
    const dropdownToggle = document.getElementById("dropdown-toggle");
    const dropdownMenu = document.getElementById("dropdown-menu");
    const dropdownClose = document.getElementById("dropdown-close");
    const drawerOverlay = document.getElementById("drawer-overlay");
    const body = document.body;

    function toggleDrawer() {
        dropdownMenu.classList.toggle("hidden");
        body.classList.toggle("overflow-hidden");
    }

    dropdownToggle.addEventListener("click", function () {
        toggleDrawer();
    });

    dropdownClose.addEventListener("click", function () {
        toggleDrawer();
    });

    drawerOverlay.addEventListener("click", function () {
        toggleDrawer();
    });

    document.addEventListener("click", function (event) {
        if (
            !dropdownMenu.contains(event.target) &&
            !dropdownToggle.contains(event.target)
        ) {
            if (!dropdownMenu.classList.contains("hidden")) {
                toggleDrawer();
            }
        }
    });
});

//SETTINGS
//manage post
document.addEventListener("DOMContentLoaded", function () {
    const managePostsToggle = document.getElementById("manage-posts-toggle");
    const managePostsContent = document.getElementById("manage-posts-content");
    const toggleIcon = document.getElementById("toggle-icon");

    managePostsToggle.addEventListener("click", function () {
        managePostsContent.classList.toggle("hidden");

        if (managePostsContent.classList.contains("hidden")) {
            toggleIcon.classList.remove("fa-chevron-up");
            toggleIcon.classList.add("fa-chevron-down");
        } else {
            toggleIcon.classList.remove("fa-chevron-down");
            toggleIcon.classList.add("fa-chevron-up");
        }
    });
});
//manage account
document.addEventListener("DOMContentLoaded", function () {
    const managePostsToggle = document.getElementById("manage-account-toggle");
    const managePostsContent = document.getElementById("manage-account-content");
    const toggleIcon = document.getElementById("toggle-account-icon");

    managePostsToggle.addEventListener("click", function () {
        managePostsContent.classList.toggle("hidden");

        if (managePostsContent.classList.contains("hidden")) {
            toggleIcon.classList.remove("fa-chevron-up");
            toggleIcon.classList.add("fa-chevron-down");
        } else {
            toggleIcon.classList.remove("fa-chevron-down");
            toggleIcon.classList.add("fa-chevron-up");
        }
    });
});


//authentication
//form validation

function validateForm() {
    const name = document.getElementById('name').value;
    const password = document.getElementById('password').value;
    const nameRegex = /^[A-Z][a-z]+\s[A-Z][a-z]+$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    let isValid = true;

    if (!nameRegex.test(name)) {
        document.getElementById('nameError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('nameError').style.display = 'none';
    }

    if (!passwordRegex.test(password)) {
        document.getElementById('passwordError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('passwordError').style.display = 'none';
    }

    return isValid;
}
// password toggler
function togglePasswordVisibility(id) {
    const passwordField = document.getElementById(id);
    const toggleIcon = passwordField.nextElementSibling;

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}

