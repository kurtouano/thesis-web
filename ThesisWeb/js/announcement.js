// Get modal elements
var modal = document.getElementById("announcementModal");
var addBtn = document.querySelector(".announcement-add");
var closeBtn = document.querySelector(".close");

modal.style.display = "none"; 


addBtn.onclick = function () {
    modal.style.display = "block";
}

closeBtn.onclick = function () {
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Handle form submission with AJAX
document.getElementById('announcementForm').addEventListener('submit', function (e) {
    e.preventDefault(); 

    var formData = new FormData(this); 

    fetch('announcement.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error); // Show error if there's an issue
        } else {
            var newAnnouncement = document.createElement('div');
            newAnnouncement.classList.add('announcement-div');
            newAnnouncement.innerHTML = `
                <div class="announcement-title">
                    ${data.announce_title}
                    <p class="announcement-timestamp">${data.timestamp}</p>
                </div>
                <p class="announcement-body">${data.announce_body}</p>
                <p class="announcement-event-date">When: ${data.announce_sched_start} to ${data.announce_sched_end}</p>
            `;
            document.getElementById('announcements-container').prepend(newAnnouncement); // Add the new announcement to the top of the list

            modal.style.display = 'none';

            document.getElementById('announcementForm').reset();
        }
    })
    .catch(error => {
        console.error('Error:', error); 
    });
});
