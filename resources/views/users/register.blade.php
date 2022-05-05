@extends('layouts.master')
@section('content')
    <form class="mt-5" id="reg-form">
      @csrf
        <div class="form-outline mb-4">
            <label class="form-label" for="name">Name</label>
            <input type="text" id="name" class="form-control"/>
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="email">Email address</label>
            <input type="email" id="email" class="form-control"/>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" class="form-control"/>
        </div>

        <button id="reg-btn" class="btn btn-primary mb-4 inline-block" style="width: 100%">Register</button>
    </form>
    <script>
    $(document).ready(function() {
            $("#reg-form").on('submit', function(e) {
              
                e.preventDefault();
                $.ajax({
                    url: "http://localhost:8000/api/register",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        name: $("#name").val(),
                        email: $("#email").val(),
                        password: $("#password").val(),
                    },
                }).done(function(token) {
                    window.location = '/api/login-page';
                    localStorage.setItem('user-token',token.token);
                }).fail(function(err) {
                    console.log(err.responseJSON.errors);
                })
            })
        });
    </script>
@endsection
