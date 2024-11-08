<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-white flex items-center justify-center h-screen">
    <!-- Notifikasi Sukses -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-500 text-white p-2 rounded shadow-lg absolute top-4 right-4 text-sm z-50" id="success-notification">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="container relative">
        <div class="flex flex-col md:flex-row w-full h-full">
            <!-- Left Side -->
            <div class="w-full md:w-3/5 hidden md:flex items-center justify-center">
                <div class="text-center">
                    <img alt="Illustration of two people sitting at a table, drinking coffee and talking" class="w-5/5 h-auto" height="626" src="<?= BASEURL; ?>/img/auth/login-admin.png" width="626" />
                </div>
            </div>

            <!-- Right Side -->
            <div class="w-full md:w-2/5 flex flex-col justify-center px-4 md:px-8 max-w-md mx-auto">
                <div class="mb-4 flex items-center">
                    <img alt="Bonanza Logo" height="50" src="<?= BASEURL; ?>/img/auth/logo.png" width="50" />
                    <span class="ml-4 text-2xl font-semibold">Cafe Bonanza</span>
                </div>
                <div class="mb-4">
                    <h1 class="text-3xl font-bold mb-2">LOGIN TO YOUR ACCOUNT</h1>
                    <p class="text-gray-500">Welcome back! Please log in to continue.</p>
                </div>
                <form action="<?= BASEURL; ?>/auth/btnLoginAdmin" class="flex flex-col items-center" id="login-form" method="POST">
                    <div class="mb-4 w-full">
                        <label class="block text-gray-700" for="email">Email</label>
                        <div class="flex items-center border border-gray-300 rounded-md p-2 w-full">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                            <input class="w-full outline-none text-base" id="email" name="email" placeholder="Email" required type="email" />
                        </div>
                    </div>
                    <div class="mb-4 w-full relative">
                        <label class="block text-gray-700" for="password">Password</label>
                        <div class="flex items-center border border-gray-300 rounded-md p-2 w-full">
                            <i class="fas fa-lock text-gray-400 mr-2"></i>
                            <input class="w-full outline-none text-base" id="password" name="password" placeholder="Password" required type="password" />
                            <i class="fas fa-eye text-gray-400 absolute right-2 top-9 cursor-pointer" id="toggle-password"></i>
                        </div>
                        <div class="text-right mt-2">
                            <a class="text-blue-500 hover:underline text-sm" href="<?= BASEURL; ?>/auth/forgotpassword">Forgot Password?</a>
                        </div>
                    </div>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="text-red-500 mb-4">
                            <?= $_SESSION['error']; ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    <button class="w-full bg-black text-white py-2 rounded-md" type="submit">
                        LOGIN
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            const notification = document.getElementById('success-notification');
            const redirectUrl = "<?= isset($_SESSION['redirect_url']) ? BASEURL . $_SESSION['redirect_url'] : BASEURL . '/auth/loginAdmin'; ?>";
            <?php unset($_SESSION['redirect_url']); ?>

            if (notification) {
                setTimeout(() => {
                    notification.classList.add('hidden');
                    window.location.href = redirectUrl;
                }, 3000); // 3 detik
            }
        };

        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
