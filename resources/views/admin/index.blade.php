@include('partials.adminheader')
@if(Auth::user()->is_admin)
@apexchartsScripts
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Overview</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-4 col-sm-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Simulate Data</h5>
                    <button class="btn btn-outline-dark">Simulate data</button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total contribution</h5>
                    <p class="card-text text-success">{{$total}} KES</p>
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
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>Thornton</td>
                            <td>@twitter</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            $('#table').DataTable({
                responsive:true
            });
        } );
    </script>
@else
    <div class="row mt-5 p-3">
        <div class="col p-3">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Whoa! Hold on</h4>
                <p>You need Administrator access to view this page</p>
                <hr>
                <p class="mb-0">Come back when you have the right permissions</p>
            </div>
        </div>
    </div>
@endunless
@include('partials.adminfooter')
