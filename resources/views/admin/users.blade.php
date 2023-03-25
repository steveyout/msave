@include('partials.adminheader')
@if(Auth::user()->is_admin)
@apexchartsScripts
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin/dashboard')}}">Overview</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12">
            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="deposit-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Add users</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Manage</button>
                </li>
            </ul>
            <div class="tab-content mt-5" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <div class="alert alert-info" role="alert">
                        <x-bi-exclamation-circle/>
                        <strong>Info</strong>
                        All fields are required
                    </div>

                    <div class="card-body">
                        <form>
                            @csrf
                            <!--name-->
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Name</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><x-bi-phone/></span>
                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
                                    </div>
                                </div>
                            <div class="mb-3">
                                <!--email-->
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><x-bi-person-add/></span>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                                </div>
                            </div>
                            <!--phone number-->
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Phone no</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><x-bi-phone/></span>
                                    <input type="tel" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="phone_no">
                                </div>
                            </div>
                            <!--id no -->
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Id no</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><x-bi-person-badge-fill/></span>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="id_no">
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="spinner spinner-border spinner-border-sm " style="display: none" role="status" aria-hidden="true"></span>
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Users</h5>
                            <div class="table-responsive">
                            <table class="table w-100" id="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone no</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Registered</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->phone_no}}</td>
                                        <td><span class="badge {{$user->is_activated?'text-bg-success':'text-bg-danger'}}">{{$user->is_activated?'active':'deactivated'}}</span> </td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            <button class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="Edit user">
                                                <x-bi-pen/>
                                            </button>

                                            <button class="btn btn-warning" data-bs-toggle="tooltip" data-bs-title="Activate/Deactivate user" onclick="activateUser('{{$user->id}}',$(this))">
                                                <span class="spinner spinner-border spinner-border-sm " style="display: none" role="status" aria-hidden="true"></span>
                                                <x-bi-check/>
                                            </button>

                                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-title="Delete user" onclick="deleteUser('{{$user->id}}',$(this))">
                                                <span class="spinner spinner-border spinner-border-sm " style="display: none" role="status" aria-hidden="true"></span>
                                                <x-bi-trash/>
                                            </button>
                                        </td>
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
        $('form').on('submit',function (e) {
            e.preventDefault()
            let form=$(this)
            let button=form.find('button[type="submit"]')
            $.ajax({
                type:'post',
                url:'{{route('admin/add')}}',
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
        $(document).ready( function () {
            $('#table').DataTable({
                responsive:true
            });
        } );

        //tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
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
<script>
    function deleteUser(id,button){
        if (!id){
            return
        }
        //confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                //fire ajax request
                $.ajax({
                    type:'post',
                    url:'{{route('admin/delete')}}',
                    data:{
                        id:id,
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
                            button.parent().parent().remove()
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
        })

    }


    ///activate deactivate
    function activateUser(id,button){
        if (!id){
            return
        }
        //ajax
                $.ajax({
                    type:'post',
                    url:'{{route('admin/activate')}}',
                    data:{
                        id:id,
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
@include('partials.adminfooter')
