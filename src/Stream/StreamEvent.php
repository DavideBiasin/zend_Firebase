<?php
namespace ZendFirebase\Stream;

use InvalidArgumentException;

/**
 * PHP7 FIREBASE LIBRARY (http://samuelventimiglia.it/)
 *
 *
 * @link https://github.com/Samuel18/zend_Firebase
 * @copyright Copyright (c) 2016-now Ventimiglia Samuel - Biasin Davide
 * @license BSD 3-Clause License
 *
 */
class StreamEvent
{

    const END_OF_LINE = "/\r\n|\n|\r/";

    /** @var string */
    private $data;

    /** @var string */
    private $eventType;


    /**
     *
     * @param string $data
     * @param string $eventType
     */
    public function __construct($data = '', $eventType = 'message')
    {
        $this->data = $data;
        $this->eventType = $eventType;
    }

    /**
     *
     * @param
     *            $raw
     *
     * @return Event
     */
    public static function parse($raw)
    {
        $event = new static();
        $lines = preg_split(self::END_OF_LINE, $raw);


        foreach ($lines as $line) {
            $matched = preg_match('/(?P<name>[^:]*):?( ?(?P<value>.*))?/', $line, $matches);

            if (! $matched) {
                throw new InvalidArgumentException(sprintf('Invalid line %s', $line));
            }

            $name = $matches['name'];
            $value = $matches['value'];

            if ($name === '') {
                // ignore comments
                continue;
            }

            switch ($name) {
                case 'event':
                    $event->eventType = $value;
                    break;
                case 'data':
                    $event->data = empty($event->data) ? $value : "$event->data\n$value";
                    break;

                default:
                    // The field is ignored.
                    continue;
            }
        }

        return $event;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getEventType()
    {
        return $this->eventType;
    }
}
