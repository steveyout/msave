@include('partials.dashheader')
@apexchartsScripts
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Overview</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-4 col-sm-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">My contribution</h5>
                    <p class="card-text text-success">{{$myContributions}} KES</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total contribution</h5>
                    <p class="card-text text-success">{{$contributions}} KES</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    {!! $chart->container() !!}

                    {!! $chart->script() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Transactions overview</h5>
                    {!! $chart1->container() !!}

                    {!! $chart1->script() !!}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Transactions</h5>

                    <table class="table" id="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Receipt No</th>
                            <th scope="col">Phone No</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$transaction->amount}} KES</td>
                                <td>{{$transaction->receipt_number}}</td>
                                <td>{{$transaction->phone_number}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            $('#table').DataTable({
                dom: 'Bfrtip',
                responsive:true,
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            });
        } );
    </script>
@include('partials.dashfooter')
