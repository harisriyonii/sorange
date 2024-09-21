<?php
session_start();
if (isset($_SESSION['admin_username'])) {
    header("location:index.php");
    exit();
}
include("config.php");

$username = "";
$password = "";
$err = "";
$success = false;

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == '' or $password == '') {
        $err .= "Silakan masukkan username dan password<br>";
    }

    if (empty($err)) {
        $sql1 = "SELECT * FROM admin WHERE username = '$username'";
        $q1 = mysqli_query($db, $sql1);
        $r1 = mysqli_fetch_array($q1);

        if (!$r1 || $r1['password'] != md5($password)) {
            $err .= "Anda Belum Daftar atau Password salah<br>";
        } else {
            $success = true;
        }
    }

    if ($success) {
        $_SESSION['admin_username'] = $username;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <section class="bg-gray-50 dark:bg-gray-900">
        <div id="app" class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Masuk Dashboard
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="" method="POST">
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input type="username" value="<?php echo htmlspecialchars($username) ?>" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 input" placeholder="username" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                        </div>
                        <button type="submit" name="login" value="LOGIN" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Masuk</button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            kamu belum punya akun? <a href="registrasi.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Daftar disini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php 
            if (!empty($err)) { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: '<?php echo $err; ?>'
                });
            <?php } 
            if ($success) { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil',
                    text: 'Anda akan diarahkan ke halaman dashboard.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = 'dashboard.php';
                });
            <?php } ?>
        });
    </script>
</body>

</html>