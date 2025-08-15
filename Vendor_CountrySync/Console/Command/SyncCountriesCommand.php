<?php
declare(strict_types=1);

namespace Vendor\CountrySync\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vendor\CountrySync\Api\CountryServiceInterface;

class SyncCountriesCommand extends Command
{
    private CountryServiceInterface $service;

    public function __construct(CountryServiceInterface $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    protected function configure()
    {
        $this->setName('vendor:countries:sync')
            ->setDescription('Sync countries from REST API into the vendor_country table');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->service->syncCountries();
        $output->writeln('<info>Country sync completed.</info>');
        return Cli::RETURN_SUCCESS;
    }
}
