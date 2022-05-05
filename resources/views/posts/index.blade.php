@extends('layouts.master')

@section('content')
<div class="mb-3 mt-5 me-3 mt-0 float-end" style="clear: both;display: block;content: '';">
    <button class="btn btn-primary show-form-modal"> <i class="fa fa-plus"></i> Add
        Post</button>
</div>
    <table class="table mt-3 table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="postTBody">
        </tbody>
    </table>
    @include('posts.form-modal')
    <script>
        $(document).ready(function() {
            let token = localStorage.getItem('user-token');
            init();
            function init(){
                getPosts();
            }
            function getPosts(){
                $.ajax({
                url:"http://localhost:8000/api/posts",
                method:"GET",
                contentType: "application/json",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': 'Bearer '+token
            },
                dataType:"json",
                success: function (posts) {
                    console.log(posts)
                posts = posts.data;
                posts.forEach(post => {
                    $(".postTBody").append(`
        <tr>
        <td>${post.id}</td>
          <td>${post.title}</td>
          <td>${post.description}</td>
          <td class="text-center"><button class="edit btn btn-sm text-primary" ><i class="fas fa-edit text-primary"></i></button></td>
          <td class="text-center"><button type="submit" class="delete btn btn-sm text-danger"><i class="fas fa-trash-alt text-danger"></i></button></td>
        </tr>
      `);
        })
            }
                
            });
            }

        $(document).on('click', '.show-form-modal', function () {
        $("#formModal").modal('show');

        $("#form").on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "/api/posts",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer '+token
                },
                data: {
                    title: $("#title").val(),
                    description: $("#description").val(),
                },
            }).done(function () {
                window.location = '/api/post-list';
            }).fail(function (err) {
                console.log(err.responseJSON.errors);
            })
        })
    });

        });
    </script>
@endsection
