<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizScoringTest extends TestCase
{
    use RefreshDatabase;

    public function test_result_page_uses_saved_attempt_when_flash_session_is_missing(): void
    {
        $user = User::factory()->create();
        $topic = Topic::create(['name' => 'PHP', 'slug' => 'php']);

        QuizAttempt::create([
            'user_id' => $user->id,
            'topic_id' => $topic->id,
            'score' => 2,
            'total_questions' => 2,
        ]);

        $response = $this->actingAs($user)->get(route('quiz.result', $topic));

        $response->assertOk();
        $response->assertSee('2 <span>/ 2</span>', false);
        $response->assertDontSee('0 <span>/ 0</span>', false);
    }

    public function test_quiz_submit_scores_answers_and_persists_attempt_total(): void
    {
        $user = User::factory()->create();
        $topic = Topic::create(['name' => 'PHP', 'slug' => 'php']);

        $firstQuestion = Question::create(['topic_id' => $topic->id, 'question_text' => 'What does PHP stand for?']);
        $firstCorrect = Answer::create(['question_id' => $firstQuestion->id, 'answer_text' => 'PHP: Hypertext Preprocessor', 'is_correct' => true]);
        Answer::create(['question_id' => $firstQuestion->id, 'answer_text' => 'Private Home Page', 'is_correct' => false]);

        $secondQuestion = Question::create(['topic_id' => $topic->id, 'question_text' => 'Which symbol starts variables?']);
        $secondCorrect = Answer::create(['question_id' => $secondQuestion->id, 'answer_text' => '$', 'is_correct' => true]);
        Answer::create(['question_id' => $secondQuestion->id, 'answer_text' => '#', 'is_correct' => false]);

        $this->actingAs($user)->post(route('quiz.submit', $topic), [
            'answer_' . $firstQuestion->id => $firstCorrect->id,
            'answer_' . $secondQuestion->id => $secondCorrect->id,
        ]);

        $this->assertDatabaseHas('quiz_attempts', [
            'user_id' => $user->id,
            'topic_id' => $topic->id,
            'score' => 2,
            'total_questions' => 2,
        ]);
    }

    public function test_leaderboard_keeps_best_attempt_per_player_topic(): void
    {
        $user = User::factory()->create();
        $topic = Topic::create(['name' => 'PHP', 'slug' => 'php']);

        QuizAttempt::create(['user_id' => $user->id, 'topic_id' => $topic->id, 'score' => 1, 'total_questions' => 2]);
        QuizAttempt::create(['user_id' => $user->id, 'topic_id' => $topic->id, 'score' => 2, 'total_questions' => 2]);

        $response = $this->actingAs($user)->get(route('leaderboard'));

        $response->assertOk();
        $scores = $response->viewData('scores');

        $this->assertCount(1, $scores);
        $this->assertSame(2, $scores->first()->score);
        $this->assertSame(2, $scores->first()->total_questions);
    }
}
