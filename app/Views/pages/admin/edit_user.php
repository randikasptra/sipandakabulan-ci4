<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola User') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .table-row-hover:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .action-btn {
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }

        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 ml-64">

    <div class="flex min-h-screen">

        <!-- Sidebar Admin -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden mt-12">

            <!-- Header Admin -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">

                <section class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto pt-24">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold text-gray-800">Edit User</h2>
                            <p class="text-gray-600 mt-2">Update user information and permissions</p>
                        </div>

                        <form action="/dashboard/admin/users/<?= $user['id'] ?>/update" method="post">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Column 1 -->
                                <div class="space-y-4">
                                    <div>
                                        <label for="username"
                                            class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                        <input type="text" name="username" id="username"
                                            value="<?= esc($user['username']) ?>" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    </div>

                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" name="email" id="email" value="<?= esc($user['email']) ?>"
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    </div>

                                    <div>
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <input type="password" name="password" id="password"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                            placeholder="Leave blank to keep current">
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="space-y-4">
                                    <div>
                                        <label for="role"
                                            class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                        <select name="role" id="role"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin
                                            </option>
                                            <option value="operator" <?= $user['role'] == 'operator' ? 'selected' : '' ?>>
                                                Operator
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="desa"
                                            class="block text-sm font-medium text-gray-700 mb-1">Desa</label>
                                        <input type="text" name="desa" id="desa" value="<?= esc($user['desa']) ?>"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="status_input"
                                                class="block text-sm font-medium text-gray-700 mb-1">Input
                                                Status</label>
                                            <select name="status_input" id="status_input"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                                <option value="belum" <?= $user['status_input'] == 'belum' ? 'selected' : '' ?>>Belum
                                                </option>
                                                <option value="sudah" <?= $user['status_input'] == 'sudah' ? 'selected' : '' ?>>Sudah
                                                </option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="status_approve"
                                                class="block text-sm font-medium text-gray-700 mb-1">Approve
                                                Status</label>
                                            <select name="status_approve" id="status_approve"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                                <option value="pending" <?= $user['status_approve'] == 'pending' ? 'selected' : '' ?>>
                                                    Pending</option>
                                                <option value="approved" <?= $user['status_approve'] == 'approved' ? 'selected' : '' ?>>
                                                    Approved</option>
                                                <option value="rejected" <?= $user['status_approve'] == 'rejected' ? 'selected' : '' ?>>
                                                    Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                                <a href="/dashboard/users"
                                    class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Back to Users
                                </a>
                                <button type="submit"
                                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition transform hover:-translate-y-0.5">
                                    Update User
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
        </div>

    </div>
</body>

</html>