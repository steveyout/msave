@include('partials.dashheader')
@apexchartsScripts
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Deposit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12">
            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="deposit-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Deposit</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Transactions</button>
                </li>
            </ul>
            <div class="tab-content mt-5" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <div class="alert alert-info" role="alert">
                        <x-bi-exclamation-circle/>
                        <strong>Info</strong>
                        Deposit will be initiated using the registered phone number
                    </div>

                    <div class="card-body">
                        <form>
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Amount</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><x-bi-coin/></span>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="amount">
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="spinner spinner-border spinner-border-sm " style="display: none" role="status" aria-hidden="true"></span>
                                    Deposit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">...</div>
            </div>
        </div>

    </div>
    <script>
        $('form').on('submit',function (e) {
            e.preventDefault()
            let form=$(this)
            let button=form.find('button[type="submit"]')
            $.ajax({
                type:'post',
                url:'{{route('initialize')}}',
                data:$(this).serialize(),
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
        })
    </script>
    <script>

    </script>
@include('partials.dashfooter')
