@extends('layout')

@section('content')
<div class="container my-4">
    <h2 class="text-center text-light mb-4">📊 Your Productivity Dashboard</h2>

    <div class="row g-4 justify-content-center">

        <!-- Total Tasks -->
        <div class="col-md-3">
            <div class="card bg-primary text-white text-center shadow rounded-4 py-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <i class="fas fa-tasks fa-2x mb-2"></i>
                    <h5>Total Tasks</h5>
                    <h2>{{ $totalTasks }}</h2>
                </div>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="col-md-3">
            <div class="card bg-success text-white text-center shadow rounded-4 py-4 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h5>Completed</h5>
                    <h2>{{ $completedTasks }}</h2>
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="col-md-3">
            <div class="card bg-warning text-dark text-center shadow rounded-4 py-4 animate__animated animate__fadeInUp animate__delay-2s">
                <div class="card-body">
                    <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                    <h5>Pending</h5>
                    <h2>{{ $pendingTasks }}</h2>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart Container -->
    <div class="row mt-5 justify-content-center">
        <div class="col-md-6">
            <canvas id="taskChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const completed = {{ $completedTasks ?? 0 }};
    const pending = {{ $pendingTasks ?? 0 }};

    const ctx = document.getElementById('taskChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending'],
            datasets: [{
                data: [completed, pending],
                backgroundColor: ['#198754', '#ffc107'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return context.label + ": " + context.raw + " tasks";
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
