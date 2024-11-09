<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
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
                    <img alt="Illustration of a person thinking with a question mark above their head" class="w-5/5 h-auto" height="626" src="https://storage.googleapis.com/a1aa/image/gfkk7Ok9A7WteUtnRSCoGFYthsW3fwmrOJkhffpJJVMM1H5dC.jpg" width="626" />
                </div>
            </div>
            <!-- Right Side -->
            <div class="w-full md:w-2/5 flex flex-col justify-center px-4 md:px-8 max-w-md mx-auto">
                <div class="mb-4 flex items-center">
                    <img alt="Bonanza Logo" height="50" src="https://storage.googleapis.com/a1aa/image/aWgYtYy8Ul7GLVtecODMhg9pF15eTHoI4tJCxeUU2yev6j8OB.jpg" width="50" />
                    <span class="ml-4 text-2xl font-semibold">
                        Cafe Bonanza
                    </span>
                </div>
                <div class="mb-4">
                    <h1 class="text-3xl font-bold mb-2">
                        FORGOT PASSWORD
                    </h1>
                    <p class="text-gray-500">
                        Enter your email to reset your password.
                    </p>
                </div>
                <form action="<?= BASEURL; ?>/auth/btnForgotPasswordAdmin" class="flex flex-col items-center" id="forgot-password-form" method="POST">
                    <div class="mb-4 w-full">
                        <label class="block text-gray-700" for="email">
                            Email
                        </label>
                        <div class="flex items-center border border-gray-300 rounded-md p-2 w-full">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                            <input class="w-full outline-none text-base" id="email" name="email" placeholder="Email" required="" type="email" />
                        </div>
                    </div>
                    <!-- Error Message -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="text-red-500 mb-4 w-full">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span><?= $_SESSION['error']; ?></span>
                            </div>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <button class="w-full bg-black text-white py-2 rounded-md mt-4" type="submit">
                        RESET PASSWORD
                    </button>
                </form>
                <div class="text-center mt-4">
                    <a class="text-blue-500 hover:underline text-sm" href="<?= BASEURL; ?>/auth/loginAdmin">
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            const notification = document.getElementById('success-notification');
            const redirectUrl = "<?= isset($_SESSION['redirect_url']) ? BASEURL . $_SESSION['redirect_url'] : BASEURL . '/auth/resetPasswordAdmin'; ?>";
            <?php unset($_SESSION['redirect_url']); ?>

            if (notification) {
                setTimeout(() => {
                    notification.classList.add('hidden');
                    window.location.href = redirectUrl;
                }, 3000); // 3 detik
            }
        };
    </script>
</body>
</html>