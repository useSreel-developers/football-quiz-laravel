<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy("created_at")->get();

        return view("questions.index", [
            "questions" => $questions,
            "title" => "Question List"
        ]);
    }

    public function create()
    {
        return view('questions.create', [
            "title" => "Add New Question"
        ]);
    }

    public function show()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            "question" => "required|max:250",
            "answer_a" => "required|max:100",
            "answer_b" => "required|max:100",
            "answer_c" => "required|max:100",
            "answer_d" => "required|max:100",
            "correct_answer" => "required|max:1",
        ]);

        if ($request->correct_answer != "A" && $request->correct_answer != "B" && $request->correct_answer != "C" && $request->correct_answer != "D") {
            abort(404);
        }

        $question = new Question();
        $question->id = Str::uuid()->toString();
        $question->question = $request->question;
        $question->answer_a = $request->answer_a;
        $question->answer_b = $request->answer_b;
        $question->answer_c = $request->answer_c;
        $question->answer_d = $request->answer_d;
        $question->correct_answer = $request->correct_answer;

        $question->save();

        return redirect()->route("questions.index")->with("success", "Question Added Successfully");
    }
}
