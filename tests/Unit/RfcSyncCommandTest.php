<?php

namespace Tests\Unit;

use App\Console\Commands\RfcSyncCommand;
use App\Support\ExternalsRssFeed;
use Mockery\MockInterface;
use SimpleXMLElement;
use Tests\TestCase;

class RfcSyncCommandTest extends TestCase
{
    public function test_command(): void
    {
        $this->mock(ExternalsRssFeed::class, function (MockInterface $mock) {
            $mock->shouldReceive('load')
                ->once()
                ->andReturn(new SimpleXMLElement(file_get_contents(base_path('tests/fixtures/externals.xml'))));
        });

        $this->artisan(RfcSyncCommand::class)->assertSuccessful();

        $this->assertDatabaseHas('rfcs', [
            'title' => '[VOTE] RFC Shorter attribute syntax change',
            'url' => 'https://wiki.php.net/rfc/shorter_attribute_syntax_change',
        ]);

        $this->assertDatabaseHas('rfcs', [
            'title' => '[VOTE] RFC Without url',
            'url' => null,
        ]);

        $this->assertDatabaseMissing('rfcs', [
            'title' => 'RFC Should not include this',
        ]);
    }
}
