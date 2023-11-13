@extends("layouts.app")

@section("content")
<h1 class="mb-3">Add New Question</h1>

@if($errors->any())
<div class="alert alert-danger">
  <ul class="m-0">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<form method="post" action="{{ route('questions.store') }}" id="questionForm">
  @csrf
  <div class="mb-3">
    <label for="question" class="form-label">Question</label>
    <input type="text" class="form-control" id="question" name="question" placeholder="Input Question" required>
  </div>
  <div class="mb-3">
    <label for="answerA" class="form-label">Answer A</label>
    <input type="text" class="form-control" id="answerA" name="answer_a" placeholder="Input Answer A" required>
  </div>
  <div class="mb-3">
    <label for="answerB" class="form-label">Answer B</label>
    <input type="text" class="form-control" id="answerB" name="answer_b" placeholder="Input Answer B" required>
  </div>
  <div class="mb-3">
    <label for="answerC" class="form-label">Answer C</label>
    <input type="text" class="form-control" id="answerC" name="answer_c" placeholder="Input Answer C" required>
  </div>
  <div class="mb-3">
    <label for="answerD" class="form-label">Answer D</label>
    <input type="text" class="form-control" id="answerD" name="answer_d" placeholder="Input Answer D" required>
  </div>
  <div class="mb-3">
    <label for="correctAnswer" class="form-label">Correct Answer</label>
    <select id="correctAnswer" class="form-select" name="correct_answer" required>
      <option value="" selected disabled>Choose Correct Answer</option>
      <option value="A">A</option>
      <option value="B">B</option>
      <option value="C">C</option>
      <option value="D">D</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
  document.getElementById('questionForm').addEventListener('submit', function(e) {
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