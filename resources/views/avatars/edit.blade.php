@extends("layouts.app")

@section("content")
<h1 class="mb-3">Edit Avatar</h1>

@if($errors->any())
<div class="alert alert-danger">
  <ul class="m-0">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<form method="post" action="{{ route('avatars.update', $avatar->id) }}" enctype="multipart/form-data" id="avatarForm">
  @csrf
  @method("PUT")
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Input Name" required value="{{ $avatar->avatar_name }}">
  </div>
  <div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="number" class="form-control" id="price" name="price" placeholder="Input Price" required value="{{ $avatar->price }}">
  </div>
  <div class="mb-3">
    <label for="avatar" class="form-label">Avatar</label>
    <input type="file" class="form-control" id="avatar" name="avatar_image" onchange="showFile(event)">
    <img class="mt-2" src="{{ $avatar->avatar_url }}" width="150px" id="file-preview" />
  </div>
  <input type="hidden" name="hidden_id" value="{{ $avatar->id }}">
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
  function showFile(event) {
    const input = event.target;
    const reader = new FileReader();
    reader.onload = function() {
      const dataURL = reader.result;
      const output = document.getElementById("file-preview");
      output.src = dataURL;
    }
    reader.readAsDataURL(input.files[0])
  }

  document.getElementById('avatarForm').addEventListener('submit', function(e) {
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