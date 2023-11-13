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
<h1>ADA ISINYA COY!!!</h1>
@endif
@endsection
