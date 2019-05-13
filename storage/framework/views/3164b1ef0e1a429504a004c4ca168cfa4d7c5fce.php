<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent('title_prefix', config('adminlte.title_prefix', '')); ?>
<?php echo $__env->yieldContent('title', config('adminlte.title', 'AdminLTE 2')); ?>
<?php echo $__env->yieldContent('title_postfix', config('adminlte.title_postfix', '')); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css')); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css')); ?>">

    <?php if(config('adminlte.plugins.select2')): ?>
        <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    <?php endif; ?>

    <?php if(config('adminlte.plugins.pace')): ?>
    <!-- Pace -->
    <link rel="stylesheet"
        href="//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/<?php echo e(config('adminlte.pace.color', 'blue')); ?>/pace-theme-<?php echo e(config('adminlte.pace.type', 'center-radar')); ?>.min.css">
    <?php endif; ?>

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/AdminLTE.min.css')); ?>">

    <?php if(config('adminlte.plugins.datatables')): ?>
        <!-- DataTables with bootstrap 3 style -->
        <link rel="stylesheet" href="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css">
    <?php endif; ?>

    <?php echo $__env->yieldContent('adminlte_css'); ?>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition <?php echo $__env->yieldContent('body_class'); ?>">

<?php echo $__env->yieldContent('body'); ?>

<script src="<?php echo e(asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>


<?php if(config('adminlte.plugins.pace')): ?>
<!-- Pace  -->
<script src="//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
<?php endif; ?>

<?php if(config('adminlte.plugins.select2')): ?>
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<?php endif; ?>

<?php if(config('adminlte.plugins.datatables')): ?>
    <!-- DataTables with bootstrap 3 renderer -->
    <script src="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
<?php endif; ?>

<?php if(config('adminlte.plugins.chartjs')): ?>
    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
<?php endif; ?>

<?php echo $__env->yieldContent('adminlte_js'); ?>

</body>
</html>
