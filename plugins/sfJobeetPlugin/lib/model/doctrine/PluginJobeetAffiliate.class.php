<?php

/**
 * JobeetAffiliate
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginJobeetAffiliate extends BaseJobeetAffiliate
{
  public function save(Doctrine_Connection $conn = null)
  {
    if (!$this->getToken())
    {
      $this->setToken(sha1($this->getEmail().rand(11111, 99999)));
    }

    return parent::save($conn);
  }

  public function activate()
  {
    $this->setIsActive(true);

    return $this->save();
  }

  public function deactivate()
  {
    $this->setIsActive(false);

    return $this->save();
  }

  public function getActiveJobs()
  {
    $q = Doctrine_Query::create()
      ->select('j.*')
      ->from('JobeetJob j')
      ->leftJoin('j.JobeetCategory c')
      ->leftJoin('c.JobeetAffiliates a')
      ->where('a.id = ?', $this->getId());

    $q = Doctrine_Core::getTable('JobeetJob')->addActiveJobsQuery($q);

    return $q->execute();
  }
}