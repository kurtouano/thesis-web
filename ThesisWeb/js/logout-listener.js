document.getElementById("logoutBtn").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default button behavior

    Swal.fire({
        title: "Are you sure you want to logout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, logout"
    }).then((result) => {
        if (result.isConfirmed) {
            // Clear session variables by sending a logout request
            fetch("logout-clear.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "action=logout"
            }).then(() => {
                window.location.href = "login.php"; // Redirect to login page
            }).catch(error => console.error("Error logging out:", error));
        }
    });
});
