<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Website</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        
        * {
            margin: 0;
            padding: 0;
        }

        :root {
            font-family: Roboto;
            --font-size-main: 1.1rem; 
            --font-size-body: 1rem; 
        }

        body {
            box-sizing: border-box;
        }

        .main {
            width: 80%;
        }

        .sidenav-section {
            width: 20%;
        }

        .nav-icons-div{
            display: flex;
            flex-direction: column;
            row-gap: 20px;
        }

        .nav-icons {
            display: flex;
            flex-direction: row;
            align-items: center;
            font-size: var(--font-size-body);
        }

        .nav-icons-img {
            width: 35px;
            height: 35px;
        }

        .nav-links {
            text-decoration: none;
        }

    </style>
</head>

<body>
    <main class="main-section"></main>
    <nav class="sidenav-section">
        <div class="nav-logo">
            ReVendIt
        </div>

        <div class="nav-icons-div">
            <div class="nav-icons">
                <img class="nav-icons-img" src="assets/statistics-icon.png" alt="">
                <a href="" class="nav-links statistics">Statistics</a>
            </div>

            <div class="nav-icons">
                <img class="nav-icons-img" src="assets/create-account-icon.png" alt="">
                <a href="" class="nav-links create-user-account">Create User Account</a>
            </div>
            
            <div class="nav-icons">
                <img class="nav-icons-img" src="assets/bin-icon.png" alt="">
                <a href="" class="nav-links bin-capacity">Bin Capacity</a>
            </div>

            <div class="nav-icons">
                <img class="nav-icons-img" src="assets/announcement-icon.png" alt="">
                <a href="" class="nav-links announcements">Announcements</a>
            </div>
        </div>

        <div><h1>PULL THIS SHIT</h1></div>
        <p>adsasdadsaawaawd</p>
    </nav>
</body>
</html>