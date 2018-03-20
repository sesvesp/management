<?php $__env->startSection('title', 'Gerenciador - Painel'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Cadastro do DOU</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
        <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Dados cadastrais</h3>
                    </div>
                    <form role="form" id="form" method="POST" action="<?php echo e(url('dou/extrair')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="box-body">
                            <label for="">Data do DOU:</label>
                            <input type="text" id="datedou" name="datedou" class="form-control" maxlength="10" placeholder="Formato dd/mm/aaaa" required></textarea>
                            <br>
                            <p class="help-block">Copie os dados das Portarias e cole no campo abaixo:</p>
                            <div class="form-group">
                                <label>Portarias:</label>
                                <textarea id="portarias" name="portarias" class="form-control" rows="7" placeholder="Cole aqui ..." required></textarea>
                            </div>
                        </div>

                        
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="save" id="save">Extrair dados</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>