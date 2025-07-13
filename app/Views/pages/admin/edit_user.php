<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola User') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'soft-lg': '0 10px 30px -5px rgba(0, 0, 0, 0.08)'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .card {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.1);
        }

        .input-field {
            transition: all 0.2s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
        }

        .btn-primary {
            background-image: linear-gradient(135deg, #0284c7 0%, #075985 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-image: linear-gradient(135deg, #0369a1 0%, #0c4a6e 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px -2px rgba(2, 132, 199, 0.5);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>

<body class="text-gray-800 ml-64">

    <div class="flex min-h-screen">

        <!-- Sidebar Admin -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header Admin -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 pt-24">

                <div class="max-w-5xl mx-auto animate-fade-in">
                    <div class="card bg-white rounded-xl shadow-soft-lg overflow-hidden border border-gray-100">
                        <!-- Card Header -->
                        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-primary-50 to-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Edit User</h2>
                                    <p class="text-gray-600 mt-1 text-sm">Update user information and permissions</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <a href="/dashboard/users" class="flex items-center text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        <span>Back to Users</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-8">
                            <form action="/dashboard/admin/users/<?= $user['id'] ?>/update" method="post">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Left Column -->
                                    <div class="space-y-6">
                                        <!-- Username Field -->
                                        <div class="form-group">
                                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-user text-gray-400"></i>
                                                </div>
                                                <input type="text" name="username" id="username" value="<?= esc($user['username']) ?>" required
                                                    class="input-field pl-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                            </div>
                                        </div>

                                        <!-- Email Field -->
                                        <div class="form-group">
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-envelope text-gray-400"></i>
                                                </div>
                                                <input type="email" name="email" id="email" value="<?= esc($user['email']) ?>" required
                                                    class="input-field pl-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                            </div>
                                        </div>

                                        <!-- Password Field -->
                                        <div class="form-group">
                                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-lock text-gray-400"></i>
                                                </div>
                                                <input type="password" name="password" id="password"
                                                    class="input-field pl-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                    placeholder="Leave blank to keep current">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                    <button type="button" class="text-gray-400 hover:text-gray-600" onclick="togglePasswordVisibility()">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="space-y-6">
                                        <!-- Role Field -->
                                        <div class="form-group">
                                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-user-tag text-gray-400"></i>
                                                </div>
                                                <select name="role" id="role"
                                                    class="input-field pl-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none bg-white">
                                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                    <option value="operator" <?= $user['role'] == 'operator' ? 'selected' : '' ?>>Operator</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Desa Field -->
                                        <div class="form-group">
                                            <label for="desa" class="block text-sm font-medium text-gray-700 mb-2">Desa</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                                </div>
                                                <input type="text" name="desa" id="desa" value="<?= esc($user['desa']) ?>"
                                                    class="input-field pl-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                            </div>
                                        </div>

                                        <!-- Status Field (Example) -->
                                        
                                    </div>
                                </div>

                                <!-- Form Footer -->
                                <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end">
                                    <button type="submit"
                                        class="btn-primary px-6 py-3 text-white font-medium rounded-lg shadow-sm">
                                        <i class="fas fa-save mr-2"></i>Update User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.querySelector('#password + div button i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>