<?php

namespace Tests\Unit\Services\Utility;

use App\Services\Utility\ValidationService;
use Tests\TestCase;

/**
 * @see \App\Services\Utility\ValidationService
 *      To the tested service class.
 */
class ValidationServiceTest extends TestCase
{
    /**
     * Ensure the service method can check whether it contains alphabets.
     *
     * @test
     * @return void
     */
    public function test_contains_alphabets(): void
    {
        // Test non-alphabet string
        $nonAlphabetsString = '`1234567890-=[]\\;,./';
        $shouldBeFalse = app(ValidationService::class)
            ->containsAlphabets($nonAlphabetsString);
        $this->assertFalse(
            $shouldBeFalse,
            'The method detects the numeric and special character as has alphabet',
        );

        // Test alphabet string
        $alphabetString = 'a b c d e f g h i j k l m n o p q r s t u v w x y z A B C D E F G H I J K L M N O P Q R S T U V W X Y Z';
        $shouldBeTrue = app(ValidationService::class)
            ->containsAlphabets($alphabetString);
        $this->assertTrue(
            $shouldBeTrue,
            'The method does not detect the string with alphabets as containing alphabet',
        );

        // Test alpha-numeric string
        $alphaNumericString = 'Test123';
        $shouldBeTrue = app(ValidationService::class)
            ->containsAlphabets($alphaNumericString);
        $this->assertTrue(
            $shouldBeTrue,
            'The method does not detect the string with alphabets and numeric as containing alphabet',
        );
    }

    /**
     * Ensure the service method can check whether it contains numeric.
     *
     * @test
     * @return void
     */
    public function test_contains_numeric(): void
    {
        // Test non-alphabet string
        $nonAlphabetsString = '`1234567890-=[]\\;,./';
        $shouldBeTrue = app(ValidationService::class)
            ->containsAlphabets($nonAlphabetsString);
        $this->assertFalse(
            $shouldBeTrue,
            'The method detects the numeric and special character as has alphabet',
        );

        // Test alphabet string
        $alphabetString = 'a b c d e f g h i j k l m n o p q r s t u v w x y z A B C D E F G H I J K L M N O P Q R S T U V W X Y Z';
        $shouldBeFalse = app(ValidationService::class)
            ->containsAlphabets($alphabetString);
        $this->assertTrue(
            $shouldBeFalse,
            'The method does not detect the string with alphabets as containing alphabet',
        );

        // Test alpha-numeric string
        $alphaNumericString = 'Test123';
        $shouldBeTrue = app(ValidationService::class)
            ->containsAlphabets($alphaNumericString);
        $this->assertTrue(
            $shouldBeTrue,
            'The method does not detect the string with alphabets and numeric as containing alphabet',
        );
    }
}
