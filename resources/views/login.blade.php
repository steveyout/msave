@include('partials.header')
<div class="container-fluid">
<h3 class="text-center mt-5">Please login to continue</h3>
</div>
<div class="container-fluid mt-4 d-flex justify-content-center">
    <div class="card col-lg-6 col-12">
        <div class="card-body">
    <form>
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><x-bi-person/></span>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><x-bi-eye-fill/></span>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember_me">
            <label class="form-check-label" for="exampleCheck1">Remember me</label>
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
</div>
<script>
    $('form').on('submit',function (e) {
        e.preventDefault()
        let form=$(this)
        let button=form.find('button[type="submit"]')
        $.ajax({
            type:'post',
            url:'{{route('auth/login')}}',
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
                    window.location.href='{{route('dashboard')}}'
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
@include('partials.footer')
