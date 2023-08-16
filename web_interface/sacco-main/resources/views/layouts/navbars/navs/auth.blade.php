
<style>
    .logo-img {
    max-height: 100px; /* Adjust the value to your desired height */
}


  

</style>

<nav class="navbar navbar-expand-lg d-flex justify-content-end " color-on-scroll="500">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('/image/20230701_221409.png') }}" alt="Logo" class="logo-img">
            {{ $navName }}
        </a>
        
            <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar burger-lines"></span>
                <span class="navbar-toggler-bar burger-lines"></span>
                <span class="navbar-toggler-bar burger-lines"></span>
            </button>
            <div class="collapse navbar-collapse d-flex justify-content-end" id="navigation">
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            
                            <span class="d-lg-none">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    <li class="nav-item @if($activePage == 'dashboard') active @endif">
                    <a class="nav-link" href="{{route('dashboard')}}">
                        <span class="no-icon">{{ __("Dashboard") }}</span>
                    </a>
                </li>

                    <li class="nav-item @if($activePage == 'table') active @endif">
                    <a class="nav-link" href="{{route('page.index', 'table')}}">
                        <span class="no-icon">{{ __('Pending Requests') }}</span>
                    </a>
                </li>
                <li class="nav-item @if($activePage == 'table') active @endif">
                    <a class="nav-link" href="{{url ('/admin/addmembers')}}">
                        <span class="no-icon">{{ __('Add sacco members') }}</span>
                    </a>
                </li>
                
                
                
                 
                <li class="nav-item @if($activePage == 'user') active @endif">
                    <a class="nav-link" href="{{route('profile.edit')}}">
                        <span class="no-icon">{{ __("Admin Profile") }}</span>
                    </a>
                </li>
                
                </li>
                <li class="nav-item @if($activePage == 'notifications') active @endif">
                    <a class="nav-link" href="{{route('page.index', 'notifications')}}">
                        <i class="nc-icon nc-bell-55"></i>
                        <span class="no-icon">{{ __("Notifications") }}</span>
                    </a>
                </li>
                    <li class="nav-item ml-auto">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
                            <span class="no-icon">{{ __('Log out') }}</span> 
                            </a>
                        </form>
                    </li>
                    
                </ul>
                
            
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#setInterestRate">Set Interest Rate</button>

<!-- The Modal -->
<div class="modal fade" id="setInterestRate" tabindex="-1" role="dialog" aria-labelledby="setInterestRate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form action="{{ route('updateInterestRate') }}" method="POST">
    @csrf
    <div class="modal-header">
        <!-- ... -->
    </div>
    <div class="modal-body">
        <input type="decimal" name="interestRate">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Set</button>
    </div>
</form>

        </div>
    </div>
</div>

                <!-- Button to trigger the modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">Upload CSV FILE</button>

<!-- The Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" name="excel_file">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

        
            </div>


            
        </div>

        
</nav>


<div style="padding: 50px; width:70%; height:20%; margin:auto;">
<div class="input-group mb-3">
<input type="date" class="form-control" id="startDate" placeholder="Start Date" aria-label="Start Date">
    <input type="date" class="form-control" id="endDate" placeholder="End Date" aria-label="End Date">
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
    </div>
</div>



</div>

<div id="resultsWrapper" style="display: flex; justify-content: space-between; align-items:center; ">
    <div id="contributionsContainer" style="padding: 5px;  margin:auto;"></div>
    <div id="loansContainer" style="padding: 5px;  margin:auto;"></div>
</div>



<script>
    document.getElementById('uploadButton').addEventListener('click', function() {
        var form = document.getElementById('uploadForm');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });

   

</script>

<script>
 document.getElementById('searchButton').addEventListener('click', function() {
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;

    // Send the start and end dates to the controller using AJAX
    $.ajax({
        type: 'POST',
        url: '/search',
        data: {
            _token: '{{ csrf_token() }}',
            start_date: startDate,
            end_date: endDate
        },
        success: function(data) {
            var contributionsHtml = '';
            var loansHtml = '';

            // Display contributions
            contributionsHtml += '<h2>Contributions</h2>';
            data.contributions.forEach(function(contribution) {
                contributionsHtml += '<p>Member Number: ' + contribution.memberNumber + ', Amount: ' + contribution.amount + '</p>';
            });

            // Display loans
            loansHtml += '<h2>Loans</h2>';
            data.loans.forEach(function(loan) {
                loansHtml += '<p>Member Number: ' + loan.memberNumber + ', Amount: ' + loan.amount + '</p>';
            });

            // Get the containers and append the HTML
            var contributionsContainer = document.getElementById('contributionsContainer');
            contributionsContainer.innerHTML = contributionsHtml;

            var loansContainer = document.getElementById('loansContainer');
            loansContainer.innerHTML = loansHtml;
        },
        error: function(error) {
            console.log(error);
        }
    });
});

</script>


