<?php

namespace TBoileau\LifecycleBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class LifecycleMaker
 * @package TBoileau\LifecycleBundle\Maker
 * @author Thomas Boileau <t-boileau@email.com>
 */
class LifecycleMaker extends AbstractMaker
{
    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @var array
     */
    private $states;

    /**
     * LifecycleMaker constructor.
     * @param FileManager $fileManager
     */
    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getCommandName(): string
    {
        return 'make:lifecycle';
    }

    /**
     * {@inheritdoc}
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->setDescription("Create a new lifecycle class")
            ->addArgument('class-name', InputArgument::REQUIRED, 'Choose a name for your lifecycle class (e.g. <fg=yellow>FooLifecycle</>)')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {
        while($state = $io->ask('Please enter the new of the new state')) {
            $this->states[] = "on_".$state;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $lifecycleClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('class-name'),
            'Lifecycle\\',
            'Lifecycle'
        );
        $generator->generateClass(
            $lifecycleClassNameDetails->getFullName(),
            __DIR__.'/../Resources/skeleton/lifecycle.tpl.php',
            [
                "states" => $this->states
            ]
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);
    }

}