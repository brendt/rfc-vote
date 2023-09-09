<?php

namespace App\Http\Controllers;

use App\Actions\CreateArgumentComment;
use App\Models\Argument;
use Illuminate\Http\Request;

final readonly class CreateArgumentCommentController
{
    public function __invoke(
        Argument $argument,
        Request $request,
        CreateArgumentComment $createArgumentComment
    ){
        $validated = $request->validate([
            'body' => ['required', 'string']
        ]);

        $user = $request->user();

        $createArgumentComment(
            argument: $argument,
            user: $user,
            body: $validated['body'],
        );

        flash('Your comment was created!');

        return redirect()->action(ArgumentCommentsController::class, $argument);
    }
}
