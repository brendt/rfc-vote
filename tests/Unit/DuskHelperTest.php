<?php

test('it renders nothing if in production env', function () {
    app()->detectEnvironment(fn () => 'production');
    expect(dusk('test'))->toBeFalse();
});

test('it renders dusk selector for given string', function () {
    expect(dusk('test'))->toEqual('dusk="test"');
});
