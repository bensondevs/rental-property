<?php

namespace App\Traits\Models\User;

use App\Models\User\UserSecurityQuestion;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasSecurityQuestion
{
    /**
     * Get security question for current authenticatable instance.
     *
     * @return HasOne
     */
    public function securityQuestion(): HasOne
    {
        return $this->hasOne(UserSecurityQuestion::class);
    }

    /**
     * Get question of the security question.
     *
     * @return string
     */
    public function getSecurityQuestion(): string
    {
        $question = $this->securityQuestion ?:
            $this->securityQuestion()->first();
        if (!$question) {
            return '';
        }

        return $question->security_question;
    }

    /**
     * Get answer of the security question.
     *
     * @return string
     */
    public function getAnswer(): string
    {
        $question = $this->securityQuestion ?:
            $this->securityQuestion()->first();
        if (!$question) {
            return '';
        }

        return $question->answer;
    }

    /**
     * Check answer is correct.
     *
     * @param string $answer
     * @return string
     */
    public function checkAnswer(string $answer): string
    {
        $actualAnswer = strtolower($this->getAnswer());
        $answer = strtolower($answer);

        return $actualAnswer === $answer;
    }
}
