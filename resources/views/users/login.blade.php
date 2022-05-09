@extends('layouts.master')
@section('content')
    <form class="mt-5" id="login-form">
        <!-- Email input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="email">Email address</label>
            <input type="email" id="email" class="form-control" />
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" class="form-control" />
        </div>

        <!-- 2 column grid layout for inline styling -->
        {{-- <div class="row mb-4">
    <div class="col d-flex justify-content-center">
      <!-- Checkbox -->
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
        <label class="form-check-label" for="form2Example31"> Remember me </label>
      </div>
    </div>

    <div class="col">
      <!-- Simple link -->
      <a href="#!">Forgot password?</a>
    </div>
  </div> --}}

        <!-- Submit button -->
        <button id="login-btn" class="btn btn-primary btn-block mb-4">Sign in</button>

        <!-- Register buttons -->
        <div class="text-center">
            <p>Not a member? <a href="{{ url('api/register-page/') }}">Register</a></p>
        </div>
    </form>
    
    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <div class="checkbox">
                <label>
                    <button class="btn btn-primary reset-password">Reset Password</button>
                </label>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            let token = localStorage.getItem('user-token');
            $("#login-form").on('submit', function(e) {
                
                e.preventDefault();
                $.ajax({
                    url: "http://localhost:8000/api/login",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token
                    },
                    data: {
                        email: $("#email").val(),
                        password: $("#password").val(),
                    },
                }).done(function(token) {
                    localStorage.setItem("user-token", token.token);
                    // console.log(localStorage.getItem('user-token'))
                    window.location = "/api/post-list"

                }).fail(function(err) {
                    console.log(err.responseJSON.errors);
                })
            });
            
        });
    </script>
@endsection
