<?php

namespace Tests\Unit\Rules;

use App\Rules\UsernameFormatRule;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Validator;

class UsernameFormatRuleTest extends TestCase
{
    public function test_it_can_validate_a_username():void
    {
       $rule = new UsernameFormatRule();

       $validator = Validator::make(
           ['username' => 'just-a-test'],
           ['username' => $rule],
       );

       $this->assertFalse($validator->fails());
    }

    public function test_it_can_invalidate_a_username():void
    {
        $rule = new UsernameFormatRule();

        $validator = Validator::make(
            ['username' => 'just a test'],
            ['username' => $rule],
        );

        $this->assertTrue($validator->fails());
        $this->assertEquals(
            'The username must be valid. Only lowercase ASCII characters are allowed. Hyphens can be used. Whitespace, underscores, and multiple hyphens are not permitted. The username cannot start or end with a hyphen.',
            $validator->errors()->first('username')
        );
    }
}
