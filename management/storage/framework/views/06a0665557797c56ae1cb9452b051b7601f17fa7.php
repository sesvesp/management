<?php $__env->startSection('title', 'Página não encontrada'); ?>

<?php $__env->startSection('message', 'Desculpe, a página que procura não pôde ser encontrada.'); ?>

<?php echo $__env->make('errors::layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>