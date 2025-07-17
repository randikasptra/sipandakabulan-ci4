<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk SIPANDAKABULAN</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Ganti icon tab jadi logo KKLA -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/LogoKKLA.png') ?>">
    <style>
        .glow-button {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }
        
        .glow-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.8);
        }
        
        .glow-button::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.7) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            transition: all 0.6s ease;
            opacity: 0;
        }
        
        .glow-button:hover::before {
            left: 100%;
            opacity: 0.8;
        }
        
        .password-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .password-toggle:hover {
            transform: scale(1.2);
        }
        
        .card-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-blue-400 via-blue-200 to-blue-400 flex flex-col items-center justify-center p-6">

   <div class="flex items-center justify-center space-x-4 mb-6">
    <img src="<?= base_url('assets/img/LogoKKLA.png') ?>" alt="Logo KKLA" class="w-20 h-20 object-contain drop-shadow-md">
    <img src="<?= base_url('assets/img/LogoKABTASIKMALAYA.png') ?>" alt="Logo Kabupaten Tasikmalaya" class="w-20 h-20 object-contain drop-shadow-md">
</div>

    <h1 class="text-lg md:text-xl font-extrabold text-center text-gray-800 mb-6 leading-relaxed tracking-wide">
        KABUPATEN TASIKMALAYA <br> PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK <br> REPUBLIK INDONESIA
    </h1>

<div class="bg-white/90 backdrop-blur-lg p-8 rounded-3xl shadow-2xl w-full max-w-md border border-white/20 relative overflow-hidden">
    <!-- Efek dekoratif -->
    <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-200 rounded-full opacity-20 blur-xl"></div>
    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-blue-300 rounded-full opacity-15 blur-xl"></div>
    
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8 font-sans tracking-tight relative">
        <span class="relative z-10">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800">Masuk</span> 
            <span class="text-blue-500">SIPANDAKABULAN</span>
        </span>
        <div class="w-24 h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full mx-auto mt-3"></div>
    </h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 p-4 bg-red-100/90 text-red-800 border border-red-300 rounded-lg backdrop-blur-sm animate-pulse-fast">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <?= session()->getFlashdata('error') ?>
            </div>
        </div>
    <?php endif; ?>
        <!-- Session Status -->
        <?php if (session()->getFlashdata('status')): ?>
            <div class="mb-4 text-sm text-green-600">
                <?= session()->getFlashdata('status') ?>
            </div>
        <?php endif; ?>

        <!-- Validation Errors -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="mb-4 text-sm text-red-600">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/login') ?>" method="POST" class="space-y-6">
    <?= csrf_field() ?>

    <!-- Hak Akses Dropdown -->
    <div class="mb-5">
        <label for="role" class="block mb-2 text-sm font-medium text-gray-700">
            <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                Hak Akses
            </span>
        </label>
        
        <div class="relative">
            <select id="role" name="role" required
                class="appearance-none w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm hover:border-blue-400 cursor-pointer">
                <option value="" disabled selected hidden>Pilih hak akses...</option>
                <option value="operator" class="py-2">Operator</option>
                <option value="admin" class="py-2">Verifikator Administrasi</option>
            </select>
            
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Email Field -->
    <div class="relative">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">
            <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
                Email
            </span>
        </label>
        <div class="relative">
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required autofocus
                class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Password Field -->
    <div class="relative">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">
            <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
                Password
            </span>
        </label>
        <div class="relative">
            <input type="password" id="password" name="password" required
                class="w-full pl-11 pr-12 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <button type="button" onclick="togglePassword()"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Remember Me -->
    <div class="flex items-center">
        <input type="checkbox" id="remember" name="remember" 
            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
        <label for="remember" class="ml-2 text-sm text-gray-600 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            Ingat Saya
        </label>
    </div>

    <!-- Masuk Button -->
    <button type="submit"
        class="glow-button w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-xl transition duration-300 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        Masuk
    </button>
</form>
    </div>

    <div
        class="bg-white/80 backdrop-blur-md mt-8 p-6 rounded-2xl shadow-md w-full max-w-md text-center text-sm text-gray-700">
        <!-- <p>Juknis 2023: <a href="#" class="font-bold text-blue-600 hover:underline">download-kepmenjuknik2023</a></p> -->
        <p class="text-red-600 font-semibold mt-4">Jika mengalami masalah username atau password, silakan email ke
            cs@evaluasikla.id</p>
    </div>

    <div
        class="bg-white/80 backdrop-blur-md mt-6 p-6 rounded-2xl shadow-md w-full max-w-3xl text-center text-gray-700 text-sm leading-relaxed">
        <strong class="block mb-3 text-gray-800 text-base">Pemerintah Daerah Berkewajiban dan Bertanggung Jawab</strong>
        Untuk melaksanakan dan mendukung kebijakan nasional dalam penyelenggaraan Perlindungan Anak melalui upaya daerah
        membangun <span class="font-bold text-blue-600">SIPANDAKABULAN</span>.<br><br>
        Pasal 21 UU No 35 Tahun 2014 tentang Perubahan Atas UU No 23 Tahun 2002 tentang Perlindungan Anak
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>