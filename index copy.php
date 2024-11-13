<?php
session_start();
include 'config/koneksi.php'; // Menghubungkan ke database
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['name'];
    $comment = $_POST['message'];

    // Sanitasi input untuk mencegah SQL Injection
    $nama = $conn->real_escape_string($nama);
    $comment = $conn->real_escape_string($comment);

    $sql = "INSERT INTO komentar (nama, comment) VALUES ('$nama', '$comment')";
    if ($conn->query($sql) === TRUE) {
        // Menyimpan pesan sukses ke dalam session
        $_SESSION['success_message'] = "Komentar berhasil dikirim!";
        // Redirect setelah berhasil menambahkan komentar
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil komentar dari database
$sql = "SELECT * FROM komentar ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   SIDAPIT
  </title>
  <link rel="icon" href="img/logo_icon.jpeg">
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&amp;display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <style>
   body {
    font-family: 'Nunito', sans-serif;
}


@keyframes bounce {
    0%, 100% {
        transform: translateY(-25%);
        animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }
    50% {
        transform: translateY(0);
        animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
}

img {
    transition: transform 0.3s ease; /* Transisi untuk efek zoom */
}

img:hover {
    transform: scale(1.3); /* Zoom in saat hover */
}
  </style>
 </head>

 <body class="bg-white">

 <header class="sticky top-0 z-10 flex justify-between items-center p-6 bg-white shadow">
  <div class="flex items-center space-x-4">
    <img src="img/logo.png" class="h-14" alt="Flowbite Logo" />
    <span class="text-blue-600 text-3xl font-bold">SIDAPIT</span>
  </div>
  <!-- Hamburger Menu Button for Mobile -->
  <button id="menu-btn" class="block lg:hidden text-blue-600 focus:outline-none">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>
  <!-- Navigation Menu -->
  <nav id="menu" class="hidden lg:flex lg:space-x-6 text-gray-600 lg:items-center">
    <a class="hover:text-blue-600" href="#">Homepage</a>
    <a class="hover:text-blue-600" href="#about">About</a>
    <a class="hover:text-blue-600" href="#team">Team</a>
    <a class="hover:text-blue-600" href="#comment">Comment</a>
  </nav>
  <div class="hidden lg:flex items-center space-x-4">
    <a class="border border-blue-600 text-black-600 px-4 py-2 rounded hover:bg-blue-600 hover:text-white" href="login.php">LOGIN</a>
    <a class="border border-blue-600 text-black-600 px-4 py-2 rounded hover:bg-blue-600 hover:text-white" href="register.php">REGISTER</a>
  </div>
</header>

<!-- Mobile Menu -->
<div id="mobile-menu" class="lg:hidden hidden flex flex-col items-center space-y-4 py-4 bg-white shadow-md">
  <a class="hover:text-blue-600" href="#">Homepage</a>
  <a class="hover:text-blue-600" href="#about">About</a>
  <a class="hover:text-blue-600" href="#team">Team</a>
  <a class="hover:text-blue-600" href="#comment">Comment</a>
  <a class="border border-blue-600 text-black-600 px-4 py-2 rounded hover:bg-blue-600 hover:text-white" href="login.php">LOGIN</a>
  <a class="border border-blue-600 text-black-600 px-4 py-2 rounded hover:bg-blue-600 hover:text-white" href="register.php">REGISTER</a>
</div>

<script>
  const menuBtn = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');

  menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>


  <main class="text-center py-20 mt-16 mb-24">
   <h1 class="text-5xl font-black text-gray-900">
    Sistem Informasi Pengelolaan
   </h1>
   <h2 class="text-5xl font-black text-sky-600 mt-2">
    Data Proyek IT
   </h2>
   <p class="text-gray-600 mt-6 max-w-2xl mx-auto">
    Sistem untuk mengelola, menyimpan, dan menganalisis data proyek IT guna mempermudah pelaporan dan pengambilan keputusan.
   </p>
   <div class="mt-8 space-x-4">
    <a class="border border-blue-600 text-black px-6 py-3 rounded hover:bg-sky-700 hover:text-white" href="login.php">
     Get Started
    </a>
   </div>
  </main>
  <div class="absolute top-1/4 left-1/4">
   <!-- <img alt="3D cube icon" class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/QXI06UrL1h5YIZ0pGwlZTOCAFLUdagrArjwZwiO9ELaK5w6E.jpg" width="50"/> -->
  </div>
  <div class="absolute top-1/4 right-1/4">
   <!-- <img alt="3D cube icon" class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/QXI06UrL1h5YIZ0pGwlZTOCAFLUdagrArjwZwiO9ELaK5w6E.jpg" width="50"/> -->
  </div>
  <div class="absolute bottom-1/4 left-1/2 transform -translate-x-1/2">
   <!-- <img alt="3D cube icon" class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/QXI06UrL1h5YIZ0pGwlZTOCAFLUdagrArjwZwiO9ELaK5w6E.jpg" width="50"/> -->
  </div>

      <!-- START ABOUT ME -->
      <div class="bg-zinc-50 py-24 sm:py-10 mt-22 mb-24" id="about">
  <div class="mx-auto max-w-7xl px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row items-center lg:justify-center space-y-8 lg:space-y-0 lg:space-x-20">
      <!-- Image on the left side -->
      <div class="lg:w-1/3 flex justify-center bounce">
        <img src="img/foto_dashboard.jpeg" alt="About SIDAPIT" class="rounded-lg shadow-lg">
      </div>

      <!-- Text content on the right side -->
      <div class="lg:w-1/2 lg:text-left">
        <p class="text-5xl font-bold tracking-tight text-gray-900 sm:text-5xl">
          About <span class="text-sky-600 font-bold">SIDAPIT</span>
        </p>
        <p class="mt-5 text-lg leading-8 text-gray-600">
          <span class="text-sky-600 font-bold">SIDAPIT</span> - Sistem Informasi Pengelola Data Proyek IT
        </p>
        <p class="mt-4 text-lg leading-8 text-gray-600 text-justify">
          Merupakan solusi yang dirancang untuk membantu perusahaan dalam mengelola informasi dan data proyek IT dengan mudah dan efisien. Melalui platform ini, kami berupaya menciptakan sistem yang mendukung proses pengambilan keputusan berdasarkan data yang terstruktur dengan baik. <span class="text-sky-600 font-bold">SIDAPIT</span> memberikan kemudahan dalam melacak kemajuan proyek, menyimpan data dengan aman, serta menyediakan laporan yang akurat untuk kebutuhan manajerial.
        </p>
      </div>
    </div>
  </div>
</div>
</div>
    <!-- STOP ABOUT ME -->

    <!-- START TEAM -->
     <section class="bg-white" id="team">
  <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 ">
      <div class="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
          <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-sky-600 dark:text-sky">Team - JAV(S)TUDIO</h2>
          <p class="font-light text-gray-500 lg:mb-16 sm:text-xl dark:text-gray-400">Kami team yang menggarap aplikasi SIDAPIT</p>
      </div> 
      <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-2">

                <!-- start Lutfan Hadi -->
          <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
              <a href="#">
                  <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg" src="img/team/lutfan.jpg" alt="Lutfan Avatar">
              </a>
              <div class="p-5">
                  <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                      <a href="#">Lutfan Hadi</a>
                  </h3>
                  <span class="text-gray-500 dark:text-gray-400">Leader & Frond End Developer</span>
                  <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">Lutfan Hadi adalah seorang Leader & Frond End Developer di JAV(S)TUDIO</p>
                  <ul class="flex space-x-4 sm:mt-0">
                      
                      <li>
                          <a href="https://github.com/Lutfanhadi" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                          </a>
                      </li>
                      
                  </ul>
              </div>
          </div> 
          <!-- stop Lutfan Hadi -->
          
          <!-- start Marco Valentine -->
          <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
              <a href="#">
                  <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg" src="img/team/marco.jpg" alt="Jese Avatar">
              </a>
              <div class="p-5">
                  <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                      <a href="#">Marco Valentine</a>
                  </h3>
                  <span class="text-gray-500 dark:text-gray-400">Frond End Developer</span>
                  <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">Marco Valentine adalah seorang Frond End Developer di JAV(S)TUDIO</p>
                  <ul class="flex space-x-4 sm:mt-0">
                      
                      <li>
                          <a href="https://github.com/maxxkyu" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                          </a>
                      </li>
                      
                  </ul>
              </div>
          </div> 
          <!-- stop Marco Valentine -->

          <!-- start Muhammad Alfin Ghozali -->
          <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
              <a href="#">
                  <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg" src="img/team/alfin.jpg" alt="Alfin Avatar">
              </a>
              <div class="p-5">
                  <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                      <a href="#">Muhammad Alfin Ghozali</a>
                  </h3>
                  <span class="text-gray-500 dark:text-gray-400">Frond End Developer</span>
                  <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">Muhammad Alfin Ghozali seorang Frond End Developer di JAV(S)TUDIO</p>
                  <ul class="flex space-x-4 sm:mt-0">
                      
                      <li>
                          <a href="https://github.com/alfin3008" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                          </a>
                      </li>
                      
                  </ul>
              </div>
          </div> 
          <!-- stop Muhammad Alfin Ghozali -->

          <!-- start Muhammad Faris Mu'taz -->
          <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
              <a href="#">
                  <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg" src="img/team/faris.jpg" alt="Faris Avatar">
              </a>
              <div class="p-5">
                  <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                      <a href="#">Muhammad Faris Mu'taz</a>
                  </h3>
                  <span class="text-gray-500 dark:text-gray-400">Frond End Developer</span>
                  <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">Muhammad Faris Mu'taz seorang Frond End Developer di JAV(S)TUDIO</p>
                  <ul class="flex space-x-4 sm:mt-0">
                      
                      <li>
                          <a href="https://github.com/FryzzMtz" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                          </a>
                      </li>
                      
                  </ul>
              </div>
          </div> 
          <!-- stop Muhammad Faris Mu'taz -->

          <!-- start Najikha Shofiyani Rhamadani -->
          <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
              <a href="#">
                  <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg" src="img/team/najikha.jpg" alt="Najikha Avatar">
              </a>
              <div class="p-5">
                  <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                      <a href="#">Najikha Shofiyani Rhamadani</a>
                  </h3>
                  <span class="text-gray-500 dark:text-gray-400">Backend Developer</span>
                  <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">Najikha Shofiyani Rhamadani seorang Backend Developer di JAV(S)TUDIO</p>
                  <ul class="flex space-x-4 sm:mt-0">
                      
                      <li>
                          <a href="https://github.com/najikhasr" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                          </a>
                      </li>
                      
                  </ul>
              </div>
          </div> 
          <!-- stop Najikha Shofiyani Rhamadani -->         

          <!-- start Okta Barka Ramadhan -->
          <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
              <a href="#">
                  <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg" src="img/team/okta.jpg" alt="Okta Avatar">
              </a>
              <div class="p-5">
                  <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                      <a href="#">Okta Barka Ramadhan</a>
                  </h3>
                  <span class="text-gray-500 dark:text-gray-400">Backend Developer & Network Engineering</span>
                  <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">Okta Barka Ramadhan seorang Backend Developer di JAV(S)TUDIO</p>
                  <ul class="flex space-x-4 sm:mt-0">
                      
                      <li>
                          <a href="https://github.com/oktakampus" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                          </a>
                      </li>
                      
                  </ul>
              </div>
          </div> 
          <!-- stop Okta Barka Ramadhan -->
          
</section>
    <!-- STOP TEAM -->

 <!-- START CONTACT SECTION -->
    <div class="bg-gray-50 py-24 sm:py-10" id="comment">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-5xl font-bold tracking-tight text-gray-900">Komentar</h2>
                <p class="mt-5 text-lg leading-8 text-gray-500">Hubungi kami untuk informasi lebih lanjut atau pertanyaan mengenai SIDAPIT.</p>
            </div>

            <div class="lg:flex lg:space-x-10">
                <!-- Contact Form -->
                <div class="lg:w-2/3 bg-white p-8 rounded-lg shadow-md">
                    <form action="#" method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-lg font-medium text-gray-700">Nama</label>
                            <input type="text" id="name" name="name" required class="mt-2 w-full px-4 py-3 rounded-md border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-sky-600">
                        </div>

                        <div>
                            <label for="message" class="block text-lg font-medium text-gray-700">Pesan</label>
                            <textarea id="message" name="message" rows="4" required class="mt-2 w-full px-4 py-3 rounded-md border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-sky-600"></textarea>
                        </div>

                        <div>
                            <button type="submit" class="w-full py-3 px-6 bg-sky-600 text-white rounded-md hover:bg-sky-700 transition duration-300">Kirim Pesan</button>
                        </div>
                    </form>
                    <?php if (isset($error)) echo "<div class='text-red-600'>$error</div>"; ?>
                </div>

                <!-- Related Topics -->
                <div class="lg:w-1/3 mt-12 lg:mt-0 bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Topik Terkait</h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="#topic1" class="text-sky-600 hover:text-sky-700 font-bold font-medium">Bagaimana cara menggunakan SIDAPIT?</a>
                            <p class="text-gray-600 text-sm">Panduan lengkap mengenai penggunaan platform kami.</p>
                        </li>
                        <li>
                            <a href="#topic2" class="text-sky-600 hover:text-sky-700 font-bold font-medium">Apakah data saya aman di SIDAPIT?</a>
                            <p class="text-gray-600 text-sm">Informasi mengenai keamanan dan privasi data pengguna.</p>
                        </li>
                        <li>
                            <a href="#topic3" class="text-sky-600 hover:text-sky-700 font-bold font-medium">Bagaimana SIDAPIT mendukung pengambilan keputusan?</a>
                            <p class="text-gray-600 text-sm">Fitur-fitur yang membantu manajer dalam menganalisis data.</p>
                        </li>
                        <li>
                            <a href="#topic4" class="text-sky-600 hover:text-sky-700 font-bold font-medium">Apakah SIDAPIT cocok untuk bisnis kecil?</a>
                            <p class="text-gray-600 text-sm">Bagaimana SIDAPIT dapat digunakan oleh perusahaan skala kecil.</p>
                        </li>
                    </ul>
                </div>
            </div>

           <div class=" p-8 rounded-lg mt-4">
                <h2 class="text-2xl font-semibold mb-4">Komentar yang ada :</h2>
                <ul class="space-y-4">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<li class='bg-white p-4 rounded-lg shadow-md flex justify-between items-center'>
                                    <div>
                                        <strong class='text-lg text-gray-800'>" . htmlspecialchars($row['nama']) . "</strong>
                                        <p class='text-gray-600'>" . htmlspecialchars($row['comment']) . "</p>
                                    </div>
                                    <span class='text-sm text-gray-500'>" . $row['tanggal'] . "</span>
                                </li>";
                        }
                    } else {
                        echo "<li class='bg-white p-4 rounded-lg shadow-md'>Tidak ada komentar.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- END CONTACT SECTION -->

<!-- FOOTER -->
<footer class="bg-gray-100 rounded-lg shadow mt-10">
    <div class="w-full max-w-screen-xl mx-auto p-6 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="#" class="flex items-center mb-4 sm:mb-0 space-x-3">
                <img src="img/logo.png" class="h-14" alt="SIDAPIT Logo" />
                <span class="self-center text-2xl font-semibold text-blue-600">SIDAPIT</span>
            </a>
            <ul class="flex space-x-4 mt-4 sm:mt-0">
                <li>
                    <a href="#" class="text-gray-600 hover:text-blue-600">Home</a>
                </li>
                <li>
                    <a href="#about" class="text-gray-600 hover:text-blue-600">About</a>
                </li>
                <li>
                    <a href="#team" class="text-gray-600 hover:text-blue-600">Team</a>
                </li>
                <li>
                    <a href="#comment" class="text-gray-600 hover:text-blue-600">Comment</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-300 sm:mx-auto" />
        <span class="block text-sm text-gray-500 sm:text-center">© 2024 <a href="#" class="hover:underline">SIDAPIT™</a>. All Rights Reserved.</span>
    </div>
</footer>
<!-- FOOTER -->

<script>
        <?php if (isset($_SESSION['success_message'])): ?>
            swal("Berhasil!", "<?php echo $_SESSION['success_message']; ?>", "success");
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
    </script>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
 </body>
</html>


