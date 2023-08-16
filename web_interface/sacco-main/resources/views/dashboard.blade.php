@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .chart {
        width: 50%;
        height: 30%;
        text-align: center;
        margin: auto;
    }

    .pie-chart {
        width: 30%;
        height: 30%;
        text-align: center;
        margin: auto;
    }

    .content {
        align-items: center;
        padding: 10px;
        margin: auto;
    }
</style>

<div class="content">
<div class="chart-container" id="report">
    <div class="chart" >
        <h3>Total Amount Deposited Each Month</h3>
        <canvas id="depositChart"></canvas>
    </div>

    <div class="pie-chart" >
        <h3>Performance of the Sacco for This Month</h3>
        <canvas id="pieChart"></canvas>
    </div>
    
   
</div>
<button id="downloadChartsPDF">Download Charts PDF</button>

</div>







<!-- Include a div to render the c -->


@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    // Function to generate and download PDF
    function downloadPDF(elementId, fileName) {
    const element = document.getElementById(elementId);
    const opt = {
        margin: 5,
        filename: fileName + '.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 0.75 }, // Adjust the scale value
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
    };

    html2pdf().from(element).set(opt).save();
}

// Handle download button clicks
document.getElementById('downloadChartsPDF').addEventListener('click', function () {
    downloadPDF('report', 'report');
});


  
</script>
<script type="text/javascript">
    $(document).ready(function() {
        // Fetch pie chart data using AJAX
        $.get('{{ route("fetchPieChartData") }}', function(data) {
            var ctx = document.getElementById('pieChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie', // Use 'pie' for pie chart
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.amounts,
                        backgroundColor: ['rgba(0, 128, 0, 1)', 'rgba(128, 0, 0, 1)'], // Customize colors
                    }],
                },
                options: { // Additional options can be added here if needed
                    responsive: true,
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        // Fetch chart data using AJAX 
        $.get('{{ route("fetchChartData") }}', function(data) {
            var ctx = document.getElementById('depositChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar', // Use 'horizontalBar' for horizontal bar chart
                data: {
                    labels: data.labels,
                    datasets: [{ 
                     
                        label: 'Total Amount Deposited each month',
                        data: data.amounts,
                        backgroundColor: 'rgba(0, 128, 0, 1)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }],
                },
                options: { // Additional options can be added here if needed
                    scales: {
                        x: {
                            beginAtZero: true // Adjust as needed
                        }
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection
