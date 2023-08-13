<?php

namespace App\Http\Controllers;

use App\Http\Requests\RfcRequest;
use App\Models\Rfc;

final readonly class RfcCreateController
{
    public function create()
    {
        return view('rfc-form', [
            'rfc' => new Rfc(),
            'action' => action([self::class, 'store']),
        ]);
    }

    public function store(RfcRequest $request)
    {
        $rfc = new Rfc($request->validated());
        $rfc->save();

        flash('Success');

        return redirect()->action([RfcEditController::class, 'edit'], $rfc);
    }
}
