<?php
/**
 * Json serializable workaround for php < 5.4
 */
interface JsonSerializable
{
    /**
     * Return array presentation of object
     *
     * @return array
     */
    function jsonSerialize();
}
