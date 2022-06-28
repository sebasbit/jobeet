<div id="job_actions">
  <h3><?php echo __('Admin') ?></h3>
  <ul>
    <?php if (!$job->getIsActivated()): ?>
      <li><?php echo link_to(__('Edit'), 'job_edit', $job) ?></li>
      <li><?php echo link_to(__('Publish'), 'job_publish', $job, array('method' => 'put')) ?></li>
    <?php endif ?>
    <li><?php echo link_to(__('Delete'), 'job_delete', $job, array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></li>
    <?php if ($job->getIsActivated()): ?>
      <li <?php $job->expiresSoon() and print 'class="expires_soon"' ?>>
        <?php if ($job->isExpired()): ?>
          <?php echo __('Expired') ?>
        <?php else: ?>
          <?php echo __(
            'Expires in %days% days',
            array('%days%' => '<strong>'.$job->getDaysBeforeExpires().'</strong>')
          ) ?>
        <?php endif ?>

        <?php if ($job->expiresSoon()): ?>
          - <?php echo link_to(
              __('Extend for another %days% days', array('%days%' => sfConfig::get('app_active_days'))),
              $job,
              array('method' => 'put')
            ) ?>
        <?php endif ?>
      </li>
    <?php else: ?>
      <li>
        [<?php echo __('Bookmark this %URL% to manage this job in the future', array('%URL%' => link_to('URL', 'job_show', $job, true))) ?>.]
      </li>
    <?php endif ?>
  </ul>
</div>
