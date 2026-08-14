<?php

use JMac\Testing\Double;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Spatie\Health\Commands\PauseHealthChecksCommand;
use Spatie\Health\Commands\ResumeHealthChecksCommand;

use function Pest\Laravel\artisan;

it('forgets cache value', function () {
    $mockRepository = Double::for(Repository::class);

    $mockRepository->expects('forget')->with(PauseHealthChecksCommand::CACHE_KEY)->returns(true);

    Cache::swap($mockRepository);

    Cache::shouldReceive('driver')->andReturn($mockRepository);

    artisan(ResumeHealthChecksCommand::class)
        ->assertSuccessful()
        ->expectsOutput('All health check resumed');
});
