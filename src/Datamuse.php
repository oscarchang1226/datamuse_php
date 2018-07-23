<?php
/**
 * Created by PhpStorm.
 * User: oscar.chang
 * Date: 7/22/18
 * Time: 10:50 PM
 */

namespace Datamuse;


class Datamuse extends DatamuseAPI implements DatamuseInterface
{
    public function getTriggers($word, $limit = 0, $options = [])
    {
        return self::related_word($word, self::POPULAR_TRIGGER_CODE, $limit, $options);
    }

}