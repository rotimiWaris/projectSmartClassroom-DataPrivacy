<?php
//include auth_session.php file on all user panel pages
session_start();
if (isset($_SESSION["users_id"])) {
    
    $mysqli = require __DIR__ . "/db.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["users_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Data Privacy And Security in Smart Classroom - HomePage</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
      body {
            background-color: #f2f2f2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        header {
            padding: 20px;
            text-align: center;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .board {
            background-color: #fff;
            border: 2px solid #ddd;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            border-radius: 10px;
            text-align: center;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            text-align: justify;
        }

    </style>
  </head>
  <body>

    <?php
    include('header.php');
    ?>

    <header>
        <h1>Smart Classroom: Data Privacy and Security</h1>
    </header>

    <main>
        <div class="board">
            <p style="color: #222;">
                In the modern era of education technology, Smart Classrooms integrate digital technologies to enhance the learning experience. However, the benefits of these technologies come with a responsibility to address data privacy and security concerns.
            </p>

            <p style="color: #222;">
                This display board emphasizes the importance of safeguarding personal information within Smart Classrooms. From student records to interactive devices, it is crucial to implement robust security measures to protect sensitive data from unauthorized access and potential breaches.
            </p>

            <p style="color: #222;">
                As we embrace the future of education technology, let's prioritize the privacy and security of our students and educators. Together, we can create a Smart Classroom environment that fosters innovation while ensuring the confidentiality and integrity of educational data.
            </p>
        </div>
    </main>
  </body>
</html>