<?php
/**
 * Created by PhpStorm.
 * User: oscar.chang
 * Date: 7/22/18
 * Time: 10:47 PM
 */

namespace Datamuse;


interface DatamuseInterface
{
    const POPULAR_TRIGGER_CODE = 'trg';

    /**
     * Get "Triggers" (words that are statistically associated with the query word in the same piece of text.)
     *
     * @param $word
     * @param int $limit
     * @param array $options
     * @return mixed
     */
    public function getTriggers ($word, $limit = 0, $options = []);
}