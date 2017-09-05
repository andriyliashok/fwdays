<?php

namespace Stfalcon\Bundle\SponsorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Stfalcon\Bundle\EventBundle\Entity\Event as Event;

/**
 * SponsorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SponsorRepository extends EntityRepository
{

    /**
     * Get all sponsors of event
     *
     * @param Event $event
     *
     * @return array List of sponsors
     */
    public function getSponsorsOfEvent(Event $event)
    {
        return  $this->getEntityManager()
            ->createQuery('
                SELECT
                    s as sponsor,
                    c.name as category_name
                FROM
                    StfalconSponsorBundle:Sponsor s
                    JOIN s.sponsorEvents se
                    JOIN se.event e
                    JOIN se.category c
                WHERE
                    e.id = :eventId
                ORDER BY
                    c.sortOrder DESC, s.sortOrder DESC
            ')
            ->setParameter('eventId', $event->getId())
            ->getResult();
    }

    /**
     * Get all sponsors of event with category
     *
     * @param Event $event
     *
     * @return array List of sponsors
     */
    public function getSponsorsOfEventWithCategory(Event $event)
    {
        $qb = $this->createQueryBuilder('s');
        return
            $qb->select('s', 'c.name', 'c.isWideContainer')
            ->where('e.id = :eventId')
            ->join('s.sponsorEvents', 'se')
            ->join('se.event', 'e')
            ->join('se.category', 'c')
            ->setParameter('eventId', $event->getId())
            ->orderBy('c.sortOrder', 'DESC')
            ->orderBy('s.sortOrder', 'DESC')
            ->getQuery()
            ->getResult();

    }

    public function getCheckedSponsorsOfActiveEvents()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT
                    s
                FROM
                    StfalconSponsorBundle:Sponsor s
                    JOIN s.sponsorEvents se
                    JOIN se.event e
                WHERE
                    e.active = true
                    AND s.onMain = true
                ORDER BY
                    s.sortOrder DESC
            ')
            ->getResult();
    }
}
