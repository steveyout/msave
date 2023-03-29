@include('partials.header')
<div class="container-fluid text-center mt-4">
    <div class="row">
        <div class="col">
            <h1 class="mt-5">Save your money with confidence</h1>
            <p>{{config('app.name')}} helps you to save money</p>
        </div>

        <div class="col">
            <img src="{{asset('images/save.jpg')}}" alt="image" width="400" height="400">
        </div>
    </div>
</div>
<div class="container-fluid mt-4">
<div class="row">
    <h2 class="text-center mb-4">Some cool features about {{config('app.name')}}</h2>
    <div class="col-lg-4 col-sm-12 col-md-12">
        <div class="card">
            <img src="{{@asset('images/logo.png')}}" class="mx-auto d-block" alt="..." width="200" height="200">
            <div class="card-body">
                <h5 class="card-title">Cool title</h5>
                <p class="card-text">Cool description for the card</p>
                <a href="#" class="btn btn-primary">Learn more</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 col-md-12">
        <div class="card">
            <img src="{{@asset('images/logo.png')}}" class="mx-auto d-block" alt="..."  width="200" height="200">
            <div class="card-body">
                <h5 class="card-title">Cool title</h5>
                <p class="card-text">Cool description for the card</p>
                <a href="#" class="btn btn-secondary">Learn more</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-sm-12 col-md-12">
        <div class="card">
            <img src="{{@asset('images/logo.png')}}" class="mx-auto d-block" alt="..."  width="200" height="200">
            <div class="card-body">
                <h5 class="card-title">Cool title</h5>
                <p class="card-text">Cool description for the card</p>
                <a href="#" class="btn btn-success">Learn more</a>
            </div>
        </div>
    </div>
</div>
</div>
@include('partials.footer')
