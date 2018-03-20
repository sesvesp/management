<?php $__env->startSection('title', 'Page Expired'); ?>

<?php $__env->startSection('message'); ?>
    A página expirou devido a inatividade.
    <br/><br/>
    Por favor, recarregue e tente novamente.
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors::layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>