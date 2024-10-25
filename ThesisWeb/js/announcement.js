// Get modal elements
var modal = document.getElementById("announcementModal");
var addBtn = document.querySelector(".announcement-add");
var closeBtn = document.querySelector(".close");

modal.style.display = "none";

addBtn.onclick = function () {
  modal.style.display = "block";
};

closeBtn.onclick = function () {
  modal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

// Handle form submission for adding announcements
document
  .getElementById("announcementForm")
  .addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this); // Get the form data

    // Send AJAX request
    fetch("announcement.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (!data.error) {
          // Create a new announcement element
          const announcementDiv = document.createElement("div");
          announcementDiv.classList.add("announcement-div");
          announcementDiv.id = "announcement-" + data.id; // Set the ID for future reference
          announcementDiv.innerHTML = `
                  <div class="announcement-title">${data.announce_title}
                    <p class="announcement-timestamp">${data.timestamp}</p>
                  </div>
                  <form method="POST" action="require/delete_announcement.php" style="display: inline;">
                    <input type="hidden" name="id" value="${data.id}">
                    <button type="button" class="announcement-delete-each" onclick="confirmDelete(this)">Delete</button>
                  </form>
                  <p class="announcement-body">${data.announce_body}</p>
                  <p class="announcement-event-date">${data.announce_sched_start} - ${data.announce_sched_end}</p>`;

          document
            .getElementById("announcements-container")
            .prepend(announcementDiv); // Add new announcement to the top
          this.reset(); // Reset the form
          modal.style.display = "none"; // Close the modal
        } else {
          console.error(data.error);
        }
      })
      .catch((error) => console.error("Error:", error));
  });

// Handle toggle delete button visibility
document.getElementById("toggle-delete").addEventListener("click", function () {
  const deleteButtons = document.querySelectorAll(".announcement-delete-each");
  deleteButtons.forEach((button) => {
    button.style.display =
      button.style.display === "none" || button.style.display === ""
        ? "inline"
        : "none";
  });
});

// Confirm deletion for each announcement
function confirmDelete(button) {
  const announcementDiv = button.closest(".announcement-div"); // Find the closest ancestor with the class 'announcement-div'
  const announcementId = button.previousElementSibling.value; // Get the ID from the hidden input

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, keep it",
  }).then((result) => {
    if (result.isConfirmed) {
      // Submit the form for deletion
      announcementDiv.querySelector("form").submit(); // Submit the form within the announcementDiv
    }
  });
}

// Attach the confirmDelete function to each delete button
document.querySelectorAll(".announcement-delete-each").forEach((button) => {
  button.onclick = function () {
    confirmDelete(this);
  };
});
