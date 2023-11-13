@extends("layouts.app")

@section("content")
<h1 class="mb-3">Question List</h1>
<a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Add Question</a>
@if($message = Session::get("success"))
<div class="alert alert-success">
  {{ $message }}
</div>
@endif

@if (count($questions) > 0)
@foreach($questions as $question)
<div class="card mb-3 border border-dark">
  <div class="card-body">
    <p class="fw-bold mb-2">{{ $loop->index + 1 }}. {{ $question->question }}</p>
    <p class="mb-0 {{ $question->correct_answer == 'A' ? 'fw-bold' : '' }}">A. {{ $question->answer_a }}</p>
    <p class="mb-0 {{ $question->correct_answer == "B" ? "fw-bold" : "" }}">B. {{ $question->answer_b }}</p>
    <p class="mb-0 {{ $question->correct_answer == "C" ? "fw-bold" : "" }}">C. {{ $question->answer_c }}</p>
    <p class="mb-0 {{ $question->correct_answer == "D" ? "fw-bold" : "" }}">D. {{ $question->answer_d }}</p>
  </div>
  <div class="card-footer">
    <a href="{{ route("questions.edit", $question->id) }}" class="btn btn-sm btn-primary">
      Edit
    </a>
    <form class="d-inline" onsubmit="deleteQuestion(event)" action="{{ route('questions.destroy', $question->id) }}" method="post">
      @csrf
      @method("delete")
      <button type="submit" class="btn btn-sm btn-danger">
        Delete
      </button>
    </form>
  </div>
</div>
@endforeach
@endif

<script>
  function deleteQuestion(e) {
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
        e.target.submit();
      }
    });
  }
</script>
@endsection
