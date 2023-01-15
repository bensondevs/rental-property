<?php

namespace App\Services\Utility;

/**
 * @see \Tests\Unit\Services\Utility\ValidationServiceTest
 *      To the class unit tester class.
 */
class ValidationService
{
    /**
     * Determine whether the validation should be aborted or not
     * when the validation fails.
     *
     * @var bool
     */
    private bool $abortIfFail;

	/**
	 * Create New Service Instance
	 *
	 * @return void
	 */
	public function __construct(bool $abortIfFail = false)
	{
		$this->abortIfFail = $abortIfFail;
	}

    /**
     * Abort when validation is failed.
     *
     * @param string $message
     * @return bool|null
     */
    private function validationFailed(string $message = ''): ?bool
    {
        if ($this->abortIfFail) {
            abort(422, $message);
        }

        return false;
    }

    /**
     * Check whether string contains alphabets.
     *
     * @param string $word
     * @return bool
     * @see \Tests\Unit\Services\Utility\ValidationServiceTest::test_contains_alphabets()
     *      To the tested service class method.
     */
    public function containsAlphabets(string $word): bool
    {
        return preg_match("/[a-z]/i", $word);
    }

    /**
     * Check whether string contains numeric.
     *
     * @param string $string
     * @return bool
     * @see \Tests\Unit\Services\Utility\ValidationServiceTest::test_contains_numeric()
     *      To the tested service class method.
     */
    public function containsNumeric(string $string): bool
    {
        return preg_match('/[0-9]/', $string);
    }

    /**
     * Check whether string contains special characters.
     *
     * @param string $string
     * @return bool
     */
    public function containsSpecialCharacters(string $string): bool
    {
        return preg_match("/[^A-Za-z0-9 ]/", $string);
    }

    /**
     * Check whether given password string is a strong password.
     *
     * @param string $password
     * @return bool
     */
    public function isAStrongPassword(string $password): bool
    {
        if (strlen($password) < 8) {
            return $this->validationFailed('The password needs to be more than 8 characters');
        }

        if (!$this->containsAlphabets($password)) {
            return $this->validationFailed('The password does not contain alpha-beth value.');
        }

        if (!$this->containsNumeric($password)) {
            return $this->validationFailed('The password does not contain numeric value.');
        }

        if (!$this->containsSpecialCharacters($password)) {
            return $this->validationFailed('The password does not contain special characters');
        }

        return true;
    }
}
