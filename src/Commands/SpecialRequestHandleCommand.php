<?php
/**
 * Created for plugin-component-request-dispatcher
 * Date: 16.07.2021
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\SpecialRequestDispatcher\Commands;

use Leadvertex\Plugin\Components\Queue\Commands\QueueHandleCommand;
use Leadvertex\Plugin\Components\SpecialRequestDispatcher\Models\SpecialRequestTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SpecialRequestHandleCommand extends QueueHandleCommand
{

    public function __construct()
    {
        parent::__construct("specialRequest");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var SpecialRequestTask $request */
        $request = SpecialRequestTask::findById($input->getArgument('id'));

        if (is_null($request)) {
            return Command::INVALID;
        }

        if ($request->send()) {
            $output->writeln("<fg=green>[{$request->getRequest()->getMethod()}}]</> {$request->getRequest()->getUri()}.");
            return Command::SUCCESS;
        }

        $output->writeln("<fg=red>[{$request->getRequest()->getMethod()}}]</> {$request->getRequest()->getUri()}.");
        return Command::FAILURE;
    }

}