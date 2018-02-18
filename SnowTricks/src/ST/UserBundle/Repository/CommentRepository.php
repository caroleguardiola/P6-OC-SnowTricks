<?php

namespace ST\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
	 public function findByTrick($trick_id, $page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->addSelect('u')
            ->where('c.trick = :trick')
	      	->setParameter('trick', $trick_id)
            ->orderBy('c.dateCreation', 'DESC')
            ->getQuery()
        ;

	    $query
	      
	      // On définit l'annonce à partir de laquelle commencer la liste
	      ->setFirstResult(($page-1) * $nbPerPage)
	      // Ainsi que le nombre d'annonce à afficher sur une page
	      ->setMaxResults($nbPerPage)
	    ;

	    // Enfin, on retourne l'objet Paginator correspondant à la requête construite
	    // (n'oubliez pas le use correspondant en début de fichier)
	    return new Paginator($query, true);
		       
    }
}
