<?php

namespace App\Command;

use App\Services\Greeting;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    private $greeting;

    public function __construct(Greeting $greeting)
    {

        $this->greeting=$greeting;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Command for testing custom console command')
            ->addArgument('name', InputArgument::REQUIRED, 'Default name')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $name = $input->getArgument('name');
        $output->writeln([
            "You typed",
            '==============',
        ]);

            $output->writeln( $this->greeting->greet(
                $name
            ));




    }
}
