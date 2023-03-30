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
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Simulate Data</h5>
                    <button class="btn btn-outline-dark" onclick="simulateTransactions($(this))">
                        <span class="spinner spinner-border spinner-border-sm " style="display: none" role="status" aria-hidden="true"></span>
                        Simulate data
                    </button>
                    <button class="btn btn-outline-info" onclick="generateUsers($(this))">
                        <span class="spinner spinner-border spinner-border-sm " style="display: none" role="status" aria-hidden="true"></span>
                        Generate users
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Total contribution</h5>
                    <p class="card-text text-success">{{$total}} KES</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-12 col-md-12 mb-4">
            <div class="card h-100">
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
                    <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Receipt No</th>
                            <th scope="col">Phone No</th>
                            <th scope="col">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$transaction->amount}} KES</td>
                                <td>{{$transaction->receipt_number}}</td>
                                <td>{{$transaction->phone_number}}</td>
                                <td>{{$transaction->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
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
    <script>
        function generateUsers(button){
            if (!button){
                return
            }
            //ajax
            $.ajax({
                type:'post',
                url:'{{route('admin/generate')}}',
                data:{
                    _token:'{{csrf_token()}}'
                },
                dataType:'json',
                beforeSend:function () {
                    button.attr('disabled',true).find('.spinner').show()
                },
                success:function (data){
                    button.attr('disabled',false).find('.spinner').hide()
                    if(!data.success){
                        Swal.fire({
                            title: 'Error!',
                            text: data.msg,
                            icon: 'error',
                            showConfirmButton: true,
                        })
                    }else{
                        //remove row from table
                        let badge=button.parent().parent().find('.badge')
                        if (badge.hasClass('text-bg-success')){
                            badge.removeClass('text-bg-success').addClass('text-bg-danger').html('deactivated')
                        }else {
                            badge.removeClass('text-bg-danger').addClass('text-bg-success').html('active')
                        }
                        Swal.fire({
                            title: 'Success!',
                            text: data.msg,
                            icon: 'success',
                            showConfirmButton: true,
                        })
                    }
                },
                error:function (){
                    button.attr('disabled',false).find('.spinner').hide()
                    Swal.fire({
                        title: 'Error!',
                        text: 'Oops! Something went wrong',
                        icon: 'error',
                        showConfirmButton: true,
                        timer: 1500
                    })
                }
            })
        }

        ////generate random dummy data
        function simulateTransactions(button){
            if (!button){
                return
            }
            //ajax
            $.ajax({
                type:'post',
                url:'{{route('admin/simulate')}}',
                data:{
                    _token:'{{csrf_token()}}'
                },
                dataType:'json',
                beforeSend:function () {
                    button.attr('disabled',true).find('.spinner').show()
                },
                success:function (data){
                    button.attr('disabled',false).find('.spinner').hide()
                    if(!data.success){
                        Swal.fire({
                            title: 'Error!',
                            text: data.msg,
                            icon: 'error',
                            showConfirmButton: true,
                        })
                    }else{
                        //remove row from table
                        let badge=button.parent().parent().find('.badge')
                        if (badge.hasClass('text-bg-success')){
                            badge.removeClass('text-bg-success').addClass('text-bg-danger').html('deactivated')
                        }else {
                            badge.removeClass('text-bg-danger').addClass('text-bg-success').html('active')
                        }
                        Swal.fire({
                            title: 'Success!',
                            text: data.msg,
                            icon: 'success',
                            showConfirmButton: true,
                        })
                    }
                },
                error:function (){
                    button.attr('disabled',false).find('.spinner').hide()
                    Swal.fire({
                        title: 'Error!',
                        text: 'Oops! Something went wrong',
                        icon: 'error',
                        showConfirmButton: true,
                        timer: 1500
                    })
                }
            })
        }
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
