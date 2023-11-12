@extends("layouts.app")

@section("content")
<h1 class="mb-3">Avatar List</h1>
<a href="{{ route('avatars.create') }}" class="btn btn-primary mb-3">Add Avatar</a>
@if($message = Session::get("success"))
<div class="alert alert-success">
  {{ $message }}
</div>
@endif

@if (count($avatars) > 0)
<div class="row row-cols-1 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
@foreach($avatars as $avatar)
<div class="col">
  <div class="card h-100">
    <img src="{{ $avatar->avatar_url }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">{{ $avatar->avatar_name }}</h5>
      <p class="card-text">Price: 
        @if($avatar->price == 0)
        Free
        @else
        {{ $avatar->price }} Diamond
        @endif
      </p>
    </div>
    <div class="card-footer">
      <a href="{{ route("avatars.edit", $avatar->id) }}" class="btn btn-sm btn-primary">
        Edit
      </a>
      <form class="d-inline" id="deleteAvatarForm" action="{{ route('avatars.destroy', $avatar->id) }}" method="post">
        @csrf
        @method("delete")
        <button type="submit" class="btn btn-sm btn-danger">
          Delete
        </button>
      </form>
    </div>
  </div>
</div>
@endforeach
</div>
@endif

<script>
  document.getElementById('deleteAvatarForm').addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
      title: 'Enter Credentials:',
      html:
        '<input id="swalUsername" class="swal2-input" placeholder="Username">' +
        '<input id="swalPassword" class="swal2-input" placeholder="Password">',
      showCancelButton: true,
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        const username = Swal.getPopup().querySelector('#swalUsername').value;
        const password = Swal.getPopup().querySelector('#swalPassword').value;

        if (username !== "admin" || password !== "admin") {
          Swal.showValidationMessage('Username or Password incorrect');
        }
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });
</script>
@endsection
