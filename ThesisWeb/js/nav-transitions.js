document.querySelector('.burger-sidenav').addEventListener('click', function() {
    const sidenav = document.querySelector('.sidenav-section');
    const navIconsContentText = document.querySelectorAll('.nav-icons-content span');
    const navIconsContent = document.querySelectorAll('.nav-icons-content');
    const navlogoImg = document.querySelector('.nav-logo-img');
    const footer = document.querySelector('.footer');
    const burgerSidenav = document.querySelector('.burger-sidenav');
    const mainSection = document.querySelector('.main-section');
    
    // Toggle the 'collapsed' class
    sidenav.classList.toggle('collapsed');
    navlogoImg.classList.toggle('collapsed');
    footer.classList.toggle('collapsed');
    burgerSidenav.classList.toggle('collapsed');
    mainSection.classList.toggle('collapsed');

    // Define padding values for different screen sizes
    let smallScreenPadding = '10px 15px';  
    let mediumScreenPadding = '12px 20px';     
    let largeScreenPadding = '12px 20px'; 

    // Define padding values for different screen sizes
    let smallScreenClosePadding = '10px 23px';  
    let mediumScreenClosePadding = '12px 30px';     
    let largeScreenClosePadding = '12px 30px'; 

    // Determine the current padding based on screen width
    let currentPadding;
    let closePadding;
    if (window.innerWidth <= 426) {
        currentPadding = smallScreenPadding;
        closePadding = smallScreenClosePadding;
    } else if (window.innerWidth > 426 && window.innerWidth <= 768) {
        currentPadding = mediumScreenPadding;
        closePadding = mediumScreenClosePadding;
    } else if (window.innerWidth > 768) {
        currentPadding = largeScreenPadding;
        closePadding = largeScreenClosePadding;
    }

    // Hide or show text based on the collapsed state
    if (sidenav.classList.contains('collapsed')) {
        navIconsContentText.forEach(content => {
            content.style.opacity = '0';
        });

        navIconsContent.forEach(content => {
            content.style.padding = currentPadding;
        });
    
    } else {
        navIconsContentText.forEach(content => {
            content.style.opacity = '1';
        });

        navIconsContent.forEach(content => {
            content.style.padding = closePadding;
        });
    }
});
