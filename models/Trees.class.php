<?php

/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 1:20 PM
 */

use Phalcon\Mvc\Collection;
use Phalcon\Mvc\Model\Validator\Between;


class Trees extends Collection
{
    public function validation()
    {
        $this->validate(
            new Between(
                array(
                    'field' => 'title',
                    'minimum' => 0,
                    'maximum' => 50,
                    'message' => 'The title must be between 0 and 50'
                )
            )
        );

        $this->validate(
            new Between(
                array(
                    'field' => 'author',
                    'minimum' => 0,
                    'maximum' => 50,
                    'message' => 'The title must be between 0 and 50'
                )
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}