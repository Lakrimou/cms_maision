<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;



class LocationVoitureRepository extends EntityRepository
{
    public function findvoiturelocation($tag)
    {
        $qb = $this->createQueryBuilder("u");

        $select = "u.prixJour , u.nbrPlace , u.tarif , mark.name AS marque, m.name AS model,qq.firstName , v.libelle , b.dateRetour , qq.website";

        $qb->select($select)
            ->join('u.model', 'm')
            ->join('m.mark', 'mark')
            ->join('u.qouiqui', "qq")
            ->leftJoin('AdminBundle:Booking','b', 'WITH', 'qq.id = b.qouiqui')
            ->Join("qq.qvilles", "qv")
            ->join('qv.ville', 'v')
            ->where('v.libelle LIKE :myTag or mark.name LIKE :myTag')
            ->setParameter('myTag', '%' . $tag . '%');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    }
}

