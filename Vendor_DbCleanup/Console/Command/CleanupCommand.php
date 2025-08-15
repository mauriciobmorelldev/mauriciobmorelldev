<?php
declare(strict_types=1);

namespace Vendor\DbCleanup\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\App\ResourceConnection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CleanupCommand extends Command
{
    private ResourceConnection $resource;

    public function __construct(ResourceConnection $resource)
    {
        parent::__construct();
        $this->resource = $resource;
    }

    protected function configure()
    {
        $this->setName('vendor:db:cleanup')
            ->setDescription('Clean old logs and optionally optimize database tables')
            ->addOption('optimize', null, InputOption::VALUE_NONE, 'Run OPTIMIZE TABLE on key log tables');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->resource->getConnection();
        $tablesToTruncate = [
            'report_event',
            'customer_log',
            'report_compared_product_index',
            'report_viewed_product_aggregated_daily',
            'report_viewed_product_aggregated_monthly',
            'report_viewed_product_aggregated_yearly'
        ];

        foreach ($tablesToTruncate as $table) {
            $tableName = $this->resource->getTableName($table);
            try {
                $connection->truncateTable($tableName);
                $output->writeln("<info>Truncated: {$tableName}</info>");
            } catch (\Throwable $e) {
                $output->writeln("<error>Failed truncating {$tableName}: {$e->getMessage()}</error>");
            }
        }

        if ($input->getOption('optimize')) {
            foreach ($tablesToTruncate as $table) {
                $tableName = $this->resource->getTableName($table);
                try {
                    $connection->query(sprintf('OPTIMIZE TABLE `%s`', $tableName));
                    $output->writeln("<comment>Optimized: {$tableName}</comment>");
                } catch (\Throwable $e) {
                    $output->writeln("<error>Failed optimizing {$tableName}: {$e->getMessage()}</error>");
                }
            }
        }

        $output->writeln('<info>Database cleanup complete.</info>');
        return Cli::RETURN_SUCCESS;
    }
}
