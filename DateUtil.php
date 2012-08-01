<?php
namespace Millwright\ConfigurationBundle;

/**
 * Date hacks and fixes
 */
final class DateUtil
{
    /**
     * Set or modify date time object
     *
     * @param \DateTime|null &$to
     * @param \DateTime|null $from
     *
     * @return \DateTime
     */
    static public function setDateTime(\DateTime &$to = null, \DateTime $from = null)
    {
        if (null === $to) {
            $to = PhpUtil::cloneObject($from);
        } else {
            $to->setTimestamp($from->getTimestamp());
            $to->setTimezone($from->getTimezone());
        }

        return $to;
    }

    /**
     * Add time interval
     *
     * @param \DateTime $date
     * @param int       $hour
     * @param int       $minute
     * @param int       $second
     *
     * @return \DateTime
     */
    static public function addTimeInterval(\DateTime $date, $hour = 0, $minute = 0, $second = 0)
    {
        $newDate = PhpUtil::cloneObject($date);
        $interval = new \DateInterval(sprintf('PT%sH%sM%sS',$hour, $minute, $second));
        $newDate->add($interval);

        return $newDate;
    }

    /**
     * Add date interval
     *
     * @param \DateTime $date
     * @param int       $year
     * @param int       $month
     * @param int       $day
     *
     * @return \DateTime
     */
    static public function addDateInterval(\DateTime $date, $year = 0, $month = 0, $day = 0)
    {
        $newDate = PhpUtil::cloneObject($date);
        $interval = new \DateInterval(sprintf('P%sY%sM%sD', $year, $month, $day));
        $newDate->add($interval);

        return $newDate;
    }
}
