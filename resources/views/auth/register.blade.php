@extends('app')

@section('content')
    <section class="d-flex flex-wrap align-items-center text-center py-5">
        <form class="p-15 m-auto w-100" style="max-width: 330px;">
            <h1 class="h3 mb-3 fw-normal">S'inscrire</h1>

            <div class="form-floating">
                <input type="name" class="form-control" placeholder="John Doe" style="margin-bottom: -1px; border-bottom-right-radius: 0; border-bottom-left-radius: 0;">
                <label for="floatingInputName">Nom</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" placeholder="john.doe@gmail.com" style="border-radius: 0;">
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe" style="border-radius: 0;">
                <label for="floatingPassword">Mot de passe</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPasswordRepeat" placeholder="Répéter le mot de passe" style="margin-bottom: 10px; border-top-left-radius: 0; border-top-right-radius: 0;">
                <label for="floatingPasswordRepeat">Répéter le mot de passe</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">S'inscrire</button>
        </form>
    </section>
@endsection
