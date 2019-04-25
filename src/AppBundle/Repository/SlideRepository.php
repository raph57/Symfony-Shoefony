<?php


namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class SlideRepository extends EntityRepository
{
$query = $this->getEntityManager()->createQuery(
'SELECT id
        FROM slide AS service
        INNER JOIN service.caId'
);

return $query->getResult();
}
}