<?php
/**
 *
 */

namespace JPry\VVVHelper\Helpers;

use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class Prompter extends Helper
{
    /**
     * @var InputDefinition
     */
    private $definition = null;

    /**
     * @var InputInterface
     */
    private $input = null;

    /**
     * @var OutputInterface
     */
    private $output = null;

    /**
     * Format for asking questions.
     *
     * @var string
     */
    private $q_format = '<question>%s</question> ';

    public function getName()
    {
        return 'prompter';
    }

    /**
     * @param InputDefinition $definition
     */
    public function setDefinition(InputDefinition $definition)
    {
        $this->definition = $definition;
    }

    /**
     * @return InputDefinition
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Retrieve the QuestionHelper object.
     *
     * @return QuestionHelper
     */
    public function getQuestionHelper()
    {
        return $this->getHelperSet()->get('question');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function setInputOutput(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }


    public function promptForArguments()
    {
        $arguments = $this->input->getArguments();
        foreach ($this->getDefinition()->getArguments() as $argument) {
            $name = $argument->getName();

            // Skip asking for which command to run
            if ('command' == $name) {
                continue;
            }

            // Only prompt if the argument wasn't set
            if (!isset($arguments[$name])) {
                $this->promptForArgument($argument);
            }
        }
    }

    private function promptForArgument(InputArgument $argument)
    {
        $response = $this->askQuestion($argument->getDescription(), $argument->getDefault());
        $this->input->setArgument($argument->getName(), $response);
    }

    /**
     * @param string $question
     *
     * @return bool
     */
    private function askConfirmationQuestion($question)
    {
        $question = new ConfirmationQuestion(sprintf($this->q_format, $question));
        return (bool) $this->getQuestionHelper()->ask($this->input, $this->output, $question);
    }

    /**
     * @param string $question
     * @param string $default
     *
     * @return string
     */
    private function askQuestion($question, $default)
    {
        $question = new Question(sprintf($this->q_format, $question), $default);
        return $this->getQuestionHelper()->ask($this->input, $this->output, $question);
    }
}
