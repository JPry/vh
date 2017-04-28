<?php

namespace JPry\VVVHelper\Command;

use JPry\VVVHelper\Helpers\Prompter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddSite extends Command
{

    /**
     * Configure the command for Symfony Console.
     *
     * @author Jeremy Pry
     */
    protected function configure()
    {
        $this
            ->setName('add')
            ->setDescription('Add a new site to VVV')
            ->addOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'The name of the site.'
            )
            ->addOption(
                'domain',
                'd',
                InputOption::VALUE_REQUIRED,
                'The domain name to use.'
            )
            ->addOption(
                'multisite',
                'm',
                InputOption::VALUE_OPTIONAL,
                'Create a multisite. "subdomain" or "subdirectory" can be passed as the type.'
            )
            ->setAliases(
                array(
                    'create',
                )
            );
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        /** @var Prompter $prompter */
        $prompter = $this->getHelper('prompter');
        $prompter->promptForArguments();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>I'm executing!</info>");
    }

}
