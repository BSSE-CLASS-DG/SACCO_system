@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')

<div class="container-fluid" >
    <div class="row" id="report">
        <div class="col-md-6">
            <!-- Loans Chart -->
            <div class="card">
                <div class="card-header">
                    Loans Chart
                </div>
                <div class="card-body">
                    <canvas id="loansChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Contributions Chart -->
            <div class="card">
                <div  class="card-header">
                    Contributions Chart
                </div>
                <div class="card-body">
                    <canvas id="contributionsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- performance Chart -->
            <div class="card">
                <div class="card-header">
                    Performance Chart
                </div>
                <div class="card-body">
                    <canvas id="averageChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Generate Report Button -->
        <div class="card">
            <div class="card-header">
                Generate Report
            </div>
            <div class="card-body">
                <button id="generateReportButton" class="btn btn-primary">Generate Report</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Generate Report Button -->
        <div class="card">
            <div class="card-header">
                Send emails
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadEmailModal">Send Email</button>
            </div>
        </div>
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    </div>
    <div class="modal fade" id="uploadEmailModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('sendEmailsWithAttachment') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="pdf_file"> <!-- Change 'excel_file' to 'pdf_file' -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
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
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().from(element).set(opt).save();
}

// Handle download button clicks
document.getElementById('generateReportButton').addEventListener('click', function () {
    downloadPDF('report', 'report');
});


  
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Fetch chart data using AJAX 
        $.get('{{ route("fetchChartData") }}', function(data) {
            var depositCtx = document.getElementById('loansChart').getContext('2d');
            var depositChart = new Chart(depositCtx, {
                type: 'bar',
                data: {
                    labels: data.loanMonths, // Use loanMonths for labels
                    datasets: [{ 
                        label: 'Loans',
                        data: data.loanAmounts, // Use loanAmounts for data
                        backgroundColor: 'rgba(34, 36, 56, 1)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }],
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        console.log("This are the charts");
            var contributionCtx = document.getElementById('contributionsChart').getContext('2d');
            var contributionChart = new Chart(contributionCtx, {
                type: 'bar',
                data: {
                    labels: data.contributionMonths,
                    datasets: [{ 
                        label: 'Total Amount Contributed each month',
                        data: data.contributionAmounts,
                        backgroundColor: 'rgba(0, 0, 0, 1)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }],
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    });
</script>

@endpush
@endsection
