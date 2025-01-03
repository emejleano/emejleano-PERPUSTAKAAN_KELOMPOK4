<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Perpustakaan Kel4</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"> {{-- tailwinds --}}

    <style>
        .navbar-toggler-icon {
            color: rgb(234, 209, 47); /* Mengubah warna ikon toggle menjadi kuning */
        }
        .profile-container .w-32 {
            width: 8rem;
            height: 8rem;
            border-radius: 9999px;
            overflow: hidden;
            margin: 0 auto;
            margin-top: 0.5rem;
        }
        .profile-container .object-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .navbar {
            background-color: #2b3e5f;
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 10px 20px; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }
        .navbar-brand {
            color: #FFD700;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .navbar-nav .nav-link {
            color: #fff;
            font-weight: 400;
            padding-left: 15px;
            padding-right: 15px;
        }
        .navbar-nav .nav-link:hover {
            color: #FFD700;
            transition: color 0.3s ease-in-out;
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="{{ route('home') }}">Kelompok4_Perpustakaan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars navbar-toggler-icon"></i> <!-- Ganti dengan ikon Font Awesome -->
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endauth
            </ul>
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <img src="{{ asset('images/guest.jpg') }}" alt="Default Profile Image" class="rounded-circle" width="30" height="30">
                            Guest
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_image_url }}" alt="Profile Image" class="rounded-circle mr-2" width="30" height="30">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-danger" id="notificationCount">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                            <a class="dropdown-item" href="{{ route('notifications.index') }}">View All Notifications</a>
                            <div id="notificationsList">
                                <p class="dropdown-item">No new notifications</p>
                            </div>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchNotifications();

            function fetchNotifications() {
                fetch('{{ route('notifications.fetch') }}')
                    .then(response => response.json())
                    .then(data => {
                        const notificationsList = document.getElementById('notificationsList');
                        const notificationCount = document.getElementById('notificationCount');
                        notificationsList.innerHTML = '';
                        if (data.notifications.length > 0) {
                            notificationCount.textContent = data.unreadCount;
                            data.notifications.forEach(notification => {
                                const notificationItem = document.createElement('a');
                                notificationItem.href = '#';
                                notificationItem.classList.add('dropdown-item');
                                notificationItem.textContent = notification.message;
                                notificationsList.appendChild(notificationItem);
                            });
                        } else {
                            notificationCount.textContent = '0';
                            notificationsList.innerHTML = '<p class="dropdown-item">No new notifications</p>';
                        }
                    });
            }

            document.getElementById('notificationsDropdown').addEventListener('click', function() {
                markAllAsRead();
            });

            function markAllAsRead() {
                fetch('{{ route('notifications.markAllAsRead') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => fetchNotifications());
            }

            setInterval(fetchNotifications, 60000); // Refresh notifications every 60 seconds
        });
    </script>
    @stack('scripts')
</body>
</html>