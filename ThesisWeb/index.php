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
            display: flex;
            flex-direction: row;
        }

        main {
            height: 100vh;
            width: 80%;
            background-color: #27963c;
        }

        .sidenav-section {
            width: 20%;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .nav-logo {
            font-size: var(--font-size-main);
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 5%;
        }

        .nav-logo-img {
            width: 200px;
        }

        .nav-icons-div{
            display: flex;
            flex-direction: column;
            row-gap: 25px;
            padding: 5% 5%;
        }

        .nav-icons {
            display: flex;
            flex-direction: row;
            align-items: center;
            font-size: var(--font-size-body);
            padding: 2% 5%;
            transition: all 0.15s;
        }

        .nav-icons:hover {
            border-radius: 2px;
            background-color: gray;
        }

        .nav-icons:hover .nav-links {
            color: white;
        }

        .nav-icons-img {
            width: 30px;
            height: 30px;
            padding-right: 5%;
        }

        .nav-links {
            text-decoration: none;
            color: black;
            transition: color 0.15s;
        }


    </style>
</head>

<body>
    <nav class="sidenav-section">
        <div class="nav-logo">
            <img class="nav-logo-img" src="assets/nav-main-logo.png" alt="">
        </div>

        <hr>

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
    </nav>

    <main class="main-section"></main>
</body>
</html>