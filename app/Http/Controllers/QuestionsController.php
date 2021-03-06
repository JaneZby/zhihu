<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use Illuminate\Http\Request;
use App\Question;
use App\Topic;
use Auth;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return 'index';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
//        dd($request->get('topics'));
        $topics = $this->normalizeTopic($request->get('topics'));
//        dd($topics);
        //$data中不含$topics
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ];
        $question = Question::create($data);
//        dd($question);
        $question->topics()->attach($topics);
        return redirect()->route('question.show', [$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $question = Question::where('id', '=', $id)->with('topics')->first();
//        dd($question);
        return view('questions.show', [
            'question' => $question,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function normalizeTopic(array $topics){
        return collect($topics)->map(function ($topic){
            if (is_numeric($topic)) {
                Topic::find($topic)->increment('questions_count');
                return (int)($topic);
            }
            $newTopic = Topic::create([
                'name' => $topic,
                'questions_count' => 1
            ]);
            return $newTopic->id;
        })->toArray();
    }
}
