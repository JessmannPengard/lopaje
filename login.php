<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="/../../../webapp/Assets/css/login.layout.css">
    <!-- Page title -->
    <title>Jessmann</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/../../../webapp/Assets/img/favicon.ico">
</head>

<body>

    <!-- Header -->
    <header>
        <nav class="nav nav-fill fixed-top nav-h align-items-center">
            <!-- Logo -->
            <div class="nav-link">
                <a href="/webapp/home"><img src="/../../../webapp/Assets/img/logo.png" alt="" srcset="" class="logo"></a>
            </div>
        </nav>
    </header>

    <!-- Content -->
    <div class="container">
        <div class="row">
            <!-- Main content -->
            <section class="content">
                <h1 class="form-title">Sign into your account</h1>
                <form action="./login/form" method="post" class="login-form">
                    <div class="mb-3">
                        <label for="user" class="form-label">Username</label>
                        <input type="text" class="form-control" name="user" placeholder="Username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <!-- Error message -->
                    <div class="mb-3">
                        <p class='error-text'>
                        </p>
                    </div>
                    <div class="mb-3">
                        <button type="submit" value="Login" class="btn btn-primary">Login</button>
                    </div>
                    <div class="mb-3">
                        <span class="form-text">Don't you have an account? </span><a href="/webapp/login/register" class="form-link">Register here</a>
                    </div>
                </form>
            </section>
            <!-- /.content -->
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <nav class="nav fixed-bottom nav-b align-items-center">
            <div class="RRSS">
                <!-- Mail -->
                <a class="text-white" href="mailto: contacto@jessmann.com"><i class="fa-regular fa-envelope fa-xl"></i></a>
                <!-- Linkedin -->
                <a class="text-white" href="https://www.linkedin.com/in/jessmann-developer"><i class="fa-brands fa-linkedin fa-xl"></i></a>
                <!-- Github -->
                <a class="text-white" href="https://github.com/JessmannPengard"><i class="fa-brands fa-github fa-xl"></i></i></a>
            </div>
            <p class="text-white copyright">Copyright &copy;
                2023 · Jessmann · All Rights Reserved
            </p>
        </nav>
    </footer>
</body>

</html>