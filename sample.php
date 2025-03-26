<html lang="en">
    <head>
        <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
        <title>Welcome to MediQue :: Home</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="medique.css">
    </head>
    <body>
        <div class="wrapper">
            <header class="header-container">
                <div class="header-bar"></div>
                <img src="logo.png" alt="MediQue Logo" class="header-image">
            </header>
        
            <main>
                <div class="content-container">
                    <div class="table-wrapper">
                        <img src="welcomeheader.png" alt="Welcome" class="image-top-right">
                        <div class="table-container">
                            <h1>Clinic Name</h1>
                            <h2>Today's Date: <?php echo date("m.d.Y"); ?></h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>City</th>
                                        <th>Emergency Contact</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>John Doe</td>
                                        <td>+1234567890</td>
                                        <td>New York</td>
                                        <td>+1122334455</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Jane Smith</td>
                                        <td>+0987654321</td>
                                        <td>Los Angeles</td>
                                        <td>+2233445566</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Placeholder Name</td>
                                        <td>+1122334455</td>
                                        <td>Chicago</td>
                                        <td>+3344556677</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h2>Register Here</h2>
                    <form>
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" placeholder="Enter your name">
            
                        <label for="email">Email:</label>
                        <input type="email" id="email" placeholder="Enter your email">
            
                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" placeholder="Enter your phone number">
            
                        <button type="submit">Register</button>
                    </form>
                </div>    
            </main>
        
            <footer>
                <p>&copy; 2025 Registration System</p>
            </footer>
        </div>
    </body>
    </html>
