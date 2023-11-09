<?php

use App\Console\Commands\RfcSyncCommand;
use App\Support\ExternalsRssFeed;
use Mockery\MockInterface;
use function Pest\Laravel\{artisan, assertDatabaseHas, assertDatabaseMissing};;

test('command', function () {
    $this->mock(ExternalsRssFeed::class, function (MockInterface $mock) {
        $mock->shouldReceive('load')
            ->once()
            ->andReturn(new SimpleXMLElement(file_get_contents(base_path('tests/fixtures/externals.xml'))));
    });

    artisan(RfcSyncCommand::class)->assertSuccessful();

    assertDatabaseHas('rfcs', [
        'title' => '[VOTE] RFC Shorter attribute syntax change',
        'url' => 'https://wiki.php.net/rfc/shorter_attribute_syntax_change',
    ]);

    assertDatabaseHas('rfcs', [
        'title' => '[VOTE] RFC Without url',
        'url' => null,
    ]);

    assertDatabaseMissing('rfcs', [
        'title' => 'RFC Should not include this',
    ]);
});
