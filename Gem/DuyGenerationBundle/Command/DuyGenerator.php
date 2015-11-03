<?php
/**
 * Code Owner: CCIntegration Inc. S.P.I.D.E.R framework
 * Modified date: 11/3/2015
 * Modified by: Duy Huynh
 */

namespace Gem\DuyGenerationBundle\Command;


use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class DuyGenerator extends ContainerAwareCommand{

    protected function getQuestionHelper()
    {
        $question = $this->getHelperSet()->get('question');
        if (!$question || get_class($question) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper') {
            $this->getHelperSet()->set($question = new QuestionHelper());
        }
        return $question;
    }
}