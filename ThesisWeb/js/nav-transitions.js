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

    // Hide or show text based on the collapsed state
    if (sidenav.classList.contains('collapsed')) {
        navIconsContentText.forEach(content => {
            content.style.opacity = '0';
        });

        navIconsContent.forEach(content => {
            content.style.padding = '12px 20px';
        });
    
    } else {
        navIconsContentText.forEach(content => {
            content.style.opacity = '1';
        });

        navIconsContent.forEach(content => {
            content.style.padding = '12px 30px';
        });
    }
});