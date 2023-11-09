<?php

use App\Http\Livewire\ArgumentList;
use App\Http\Livewire\SortField;
use App\Models\Argument;
use App\Models\Rfc;
use Livewire\Livewire;

test('admin can delete any argument', function () {
    $user = $this->login(null, true);
    $argument = Argument::factory()->create();

    Livewire::test(ArgumentList::class, ['rfc' => $argument->rfc, 'user' => $user])
        ->call('deleteArgument', $argument->id)
        ->assertNotSet('isConfirmingDelete', null)
        ->call('deleteArgument', $argument->id)
        ->assertSet('isConfirmingDelete', null)
        ->assertOk();

    expect($user->can('delete', $argument))->toBeTrue();
    $this->assertDatabaseCount('arguments', 0);
});

test('delete can be canceled', function () {
    $user = $this->login(null, true);
    $argument = Argument::factory()->create();

    Livewire::test(ArgumentList::class, ['rfc' => $argument->rfc, 'user' => $user])
        ->call('deleteArgument', $argument->id)
        ->assertNotSet('isConfirmingDelete', null)
        ->call('cancelDeleteArgument', $argument->id)
        ->assertSet('isConfirmingDelete', null)
        ->assertOk();

    $this->assertDatabaseCount('arguments', 1);
});

test('user can delete only his own arguments', function () {
    $rfc = Rfc::factory()->create();
    $user = $this->login();

    $arguments = Argument::factory(2)->sequence(
        [
            'rfc_id' => $rfc->id,
            'user_id' => $user->id,
        ],
        [
            'rfc_id' => $rfc->id,
        ],
    )->create();

    Livewire::test(ArgumentList::class, ['rfc' => $rfc, 'user' => $user])
        ->call('deleteArgument', $arguments[0]->id)
        ->assertNotSet('isConfirmingDelete', null)
        ->call('deleteArgument', $arguments[0]->id)
        ->assertSet('isConfirmingDelete', null)
        ->assertOk();

    Livewire::test(ArgumentList::class, ['rfc' => $rfc, 'user' => $user])
        ->call('deleteArgument', $arguments[1]->id)
        ->assertNotSet('isConfirmingDelete', null)
        ->call('deleteArgument', $arguments[1]->id)
        ->assertSet('isConfirmingDelete', null)
        ->assertOk();

    expect($user->can('delete', $arguments[0]))->toBeTrue();
    expect($user->can('delete', $arguments[1]))->toBeFalse();
    $this->assertDatabaseCount('arguments', 1);
});

test('admin can edit argument', function () {
    $user = $this->login(null, true);
    $argument = Argument::factory()->create();

    Livewire::test(ArgumentList::class, ['rfc' => $argument->rfc, 'user' => $user])
        ->call('editArgument', $argument->id)
        ->assertNotSet('isEditing', null)
        ->assertNotSet('body', null)
        ->call('editArgument', $argument->id)
        ->assertSet('isEditing', null)
        ->assertSet('body', null)
        ->assertOk();

    expect($user->can('edit', $argument))->toBeTrue();
});

test('user can edit only his own arguments', function () {
    $rfc = Rfc::factory()->create();
    $user = $this->login();

    $arguments = Argument::factory(2)->sequence(
        [
            'rfc_id' => $rfc->id,
            'user_id' => $user->id,
        ],
        [
            'rfc_id' => $rfc->id,
        ],
    )->create();

    Livewire::test(ArgumentList::class, ['rfc' => $rfc, 'user' => $user])
        ->call('editArgument', $arguments[1]->id)
        ->assertSet('isEditing', null)
        ->assertSet('body', null)
        ->assertOk();

    expect($user->can('edit', $arguments[0]))->toBeTrue();
    expect($user->can('edit', $arguments[1]))->toBeFalse();
});

test('preferred sort is set after switching', function () {
    $rfc = Rfc::factory()->create();
    $user = $this->login();

    expect($user->refresh()->preferred_sort_field)->toBe(SortField::VOTE_COUNT);

    Livewire::test(ArgumentList::class, ['rfc' => $rfc, 'user' => $user])
        ->set('sortField', SortField::CREATED_AT->value)
        ->assertOk();

    expect($user->refresh()->preferred_sort_field)->toBe(SortField::CREATED_AT);
});
