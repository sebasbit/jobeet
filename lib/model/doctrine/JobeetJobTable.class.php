<?php

/**
 * JobeetJobTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class JobeetJobTable extends Doctrine_Table
{
  static public $types = array(
    'full-time' => 'Full time',
    'part-time' => 'Part time',
    'freelance' => 'Freelance',
  );

  public static function getInstance()
  {
    return Doctrine_Core::getTable('JobeetJob');
  }

  public function getTypes()
  {
    return self::$types;
  }

  public function retrieveActiveJob(Doctrine_Query $q)
  {
    $q->andWhere('a.expires_at > ?', date('Y-m-d h:i:s', time()));

    return $q->fetchOne();
  }

  public function getActiveJobs(Doctrine_Query $q = null)
  {
    return $this->addActiveJobsQuery($q)->execute();
  }

  public function countActiveJobs(Doctrine_Query $q = null)
  {
    return $this->addActiveJobsQuery($q)->count();
  }

  public function addActiveJobsQuery(Doctrine_Query $q = null)
  {
    if (is_null($q))
    {
      $q = Doctrine_Query::create()
        ->from('JobeetJob j');
    }

    $alias = $q->getRootAlias();

    $q->andWhere($alias . '.expires_at > ?', date('Y-m-d h:i:s', time()))
      ->andWhere($alias . '.is_activated = ?', 1)
      ->addOrderBy($alias . '.expires_at DESC');

    return $q;
  }

  public function cleanup($days)
  {
    $q = $this->createQuery('a')
      ->delete()
      ->andWhere('a.is_activated = ?', 0)
      ->andWhere('a.created_at < ?', date('Y-m-d', time() - 86400 * $days));

    return $q->execute();
  }

  public function retrieveBackendJobList(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();
    $q->leftJoin($rootAlias . '.JobeetCategory c');
    return $q;
  }

  public function getLatestPost()
  {
    $q = Doctrine_Query::create()
      ->from('JobeetJob j');
    $this->addActiveJobsQuery($q);

    return $q->fetchOne();
  }

  public function getForToken(array $parameters)
  {
    $affiliate = Doctrine_Core::getTable('JobeetAffiliate') ->findOneByToken($parameters['token']);
    if (!$affiliate || !$affiliate->getIsActive())
    {
      throw new sfError404Exception(sprintf('Affiliate with token "%s" does not exist or is not activated.', $parameters['token']));
    }

    return $affiliate->getActiveJobs();
  }
}
