<?php

namespace App\Http\Controllers;

use App\Service\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @var QuestionService
     */
    private $question_service;

    public function __construct(QuestionService $question_service)
    {
        $this->question_service = $question_service;
    }

    public function getQuestion(Request $request)
    {
        $question = $this->question_service->getNextQuestion(
            $request->get('question_id'),
            $request->get('question_answer') == "true"
        );

        return [
            'question' => $question,
        ];
    }

    public function saveQuestion(Request $request)
    {
        if (!$request->has(['question_id', 'new_animal', 'new_question'])) {
            return response("", 400);
        }

        $this->question_service->newQuestion(
            intval($request->get('question_id')),
            $request->get('new_animal'),
            $request->get('new_question')
        );

        return [];
    }
}

