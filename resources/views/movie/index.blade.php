@extends('app')

@section('content')
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Films</h1>
            </div>
        </div>
    </section>

    <div class="py-5 bg-light">
        <movies-list/>
    </div>
@endsection
