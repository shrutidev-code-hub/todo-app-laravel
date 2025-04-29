<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!-- Toastr CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

   <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>


    <style>
        body {
            background: #f0f4f8;
            font-family: 'Poppins', sans-serif;
            color: #1e1e1e;
        }
    
        .glass-card {
            background: #ffffff;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
    
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }
    
        .navbar-brand {
            font-weight: 600;
            font-size: 1.4rem;
            color: #5e60ce !important;
        }
    
        .btn-primary {
            background-color: #5e60ce;
            border: none;
        }
    
        .btn-primary:hover {
            background-color: #4ea8de;
        }
    
        .btn-outline-light, .btn-outline-danger, .btn-success, .btn-sm {
            border-radius: 0.8rem;
        }
    
        input.form-control, .btn {
            border-radius: 1rem !important;
        }
    
        .task-item {
            background: #f8f9fa;
            border-radius: 1rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    
        .task-item:hover {
            background: #e9f0fb;
        }
    
        small {
            color: #6c757d;
        }
    
        .btn-group .btn {
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
        }
    
        ::placeholder {
            color: #999 !important;
        }
        .modal-content {
        border-radius: 1rem;
        background: #fff;
        color: #000;
    }
    </style>
    
</head>
<body>

<nav class="navbar navbar-expand-lg px-4 py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index') }}">✨ To-Do App</a>


        @auth
            <form class="ms-auto" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-dark">Logout</button>
            </form>
        @endauth

        <button class="btn btn-outline-light ms-3" onclick="toggleTheme()">
            <i class="fas fa-moon" id="theme-icon"></i>
        </button>
        
        <a href="{{ route('dashboard') }}" class="nav-link text-dark">Dashboard</a>

    </div>
</nav>

<div class="container py-5">
    @yield('content')
</div>

</body>
</html>
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.setAttribute('data-bs-theme', 'dark');
    }
</script>
<script>
    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        document.getElementById('theme-icon').className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }
</script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Bootstrap JS (modal fix) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
