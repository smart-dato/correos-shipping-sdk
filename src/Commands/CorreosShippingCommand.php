<?php

namespace SmartDato\CorreosShipping\Commands;

use Illuminate\Console\Command;

class CorreosShippingCommand extends Command
{
    public $signature = 'correos-shipping-sdk';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
