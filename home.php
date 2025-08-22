<?php
session_start();

// If already logged in, redirect accordingly
if (isset($_SESSION['admin_id'])) {
    header("Location: admin/dashboard.php");
    exit;
}
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Art Gallery - Welcome</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- custom css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #981573, #1f1c2c);
            color: #fff;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .welcome-container {
            text-align: center;
            animation: fadeIn 2s ease-in-out;
        }

        h1 {
            font-size: 3rem;
            font-weight: bold;
            background: -webkit-linear-gradient(#ffdde1, #ee9ca7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: glow 2s infinite alternate;
        }

        p {
            font-size: 1.2rem;
            color: #f8f9fa;
        }

        .btn-custom {
            font-size: 1.2rem;
            padding: 12px 30px;
            border-radius: 30px;
            transition: transform 0.3s, background-color 0.3s;
        }

        .btn-custom:hover {
            transform: scale(1.1);
        }

        .btn-admin {
            background-color: #ff6ec7;
            border: none;
        }

        .btn-admin:hover {
            background-color: #d63384;
        }

        .btn-user {
            background-color: #6ec1ff;
            border: none;
        }

        .btn-user:hover {
            background-color: #0d6efd;
        }

        a.text-info {
            color: #ffb3ec !important;
        }

        a.text-info:hover {
            text-decoration: underline;
        }
        .tagline {
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-style: italic;
            color: #ffd1dc;
        }
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* Floating background circles for creative feel */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 120px;
            height: 120px;
            top: 10%;
            left: 15%;
        }

        .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 40%;
            right: 10%;
            animation-duration: 8s;
        }

        .circle:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 15%;
            left: 20%;
            animation-duration: 10s;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">

    <!-- floating circles -->
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>

    <div class="welcome-container">
        <h1 class="mb-4">🎨 Anupam’s Art Space</h1>
        <p class="tagline">Where Every Canvas Speaks a Thousand Words</p>
        <p class="mb-4">Choose how you want to enter:</p>
        <a href="admin/index.php" class="btn btn-custom btn-admin me-3">Admin Login</a>
        <a href="login.php" class="btn btn-custom btn-user">User Login</a>
        <p class="mt-3">Don’t have an account? <a href="signup.php" class="text-info">Sign up here</a></p>
    </div>

</body>

</html>