<?php

namespace App\Service;

use App\Model\Question;
use Illuminate\Support\Facades\DB;

class QuestionService
{
    /**
     * @var array
     */
    private $starting_animals = [
        'Dog',
        'Cat',
        'Monkey',
        'Human',
        'Wombat',
        'Sloth',
        'Shark',
        'Elephant',
    ];

    /**
     * Get the next question based on a current question and the answer.
     *
     * @param int|null $question_id
     * @param bool|null $question_answer
     * @return Question
     */
    public function getNextQuestion(int $question_id = null, bool $question_answer = null) : Question
    {
        // Try to find the next question.
        if (is_null($question_id) || is_null($question_answer)) {
            $question = Question::query()
                ->whereNull('parent_question_id')
                ->orderBy(DB::raw('RAND()'))
                ->first();
        } else {
            $question = Question::query()
                ->where('parent_question_id', $question_id)
                ->where('parent_action', $question_answer ? 1 : 0)
                ->first();
        }

        // Create a new chain of questions if none was found.
        if (is_null($question)) {
            $question = $this->generateRandomQuestion();
        }
        return $question;
    }

    /**
     * Insert a new question and a new guess in the decision-tree.
     * Rearrange the existing node, so that it is under the question.
     *
     * @param int $question_id
     * @param string $new_animal
     * @param string $new_question
     */
    public function newQuestion(int $question_id, string $new_animal, string $new_question)
    {
        DB::transaction(function () use ($question_id, $new_animal, $new_question) {
            $old_question = Question::find($question_id);

            // Create the new question.
            $question = new Question();
            $question->type = Question::QUESTION;
            $question->question = trim($new_question);
            $question->parent_question_id = $old_question->parent_question_id;
            $question->parent_action = $old_question->parent_action;
            $question->save();

            // Add the new animal as an answer the that question.
            $new_animal_question = new Question();
            $new_animal_question->type = Question::GUESS;
            $new_animal_question->question = trim($new_animal);
            $new_animal_question->parent_question_id = $question->id;
            $new_animal_question->parent_action = true;
            $new_animal_question->save();

            // Add the old animal as the other answer to that question.
            $old_question->parent_question_id = $question->id;
            $old_question->parent_action = false;
            $old_question->save();
        });
    }

    /**
     * Generate a new question with a random animal.
     *
     * @return Question
     */
    public function generateRandomQuestion() : Question
    {
        // Find a random animal to start with.
        $animal = collect($this->starting_animals)->random();

        // Store the question in the database.
        $question = new Question();
        $question->type = Question::GUESS;
        $question->question = $animal;
        $question->save();

        return $question;
    }
}
