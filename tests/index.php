<?php
    // Initialize the bootstraping operations
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
?>

<?php @require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading"><?php echo Language::lang('Global.index.heading'); ?></h1>
                <p class="lead text-muted"><?php echo Language::lang('Global.index.sub_title'); ?></p>
                <p>
                    <a href="all.php" class="btn btn-primary"><?php echo Language::lang('Global.index.button.execute_all'); ?></a>
                    <a href="index.php" class="btn btn-secondary"><?php echo Language::lang('Global.index.button.refresh_list'); ?></a>
                </p>
            </div>
        </section>
        <div class="container">
            <?php
                if (!empty($available_tests) && !isset($class_test)) {
                    foreach ($available_tests as $category => $classes) {
                        ?>
                <div class="card" style="margin-bottom: 10px;">
                    <div class="card-header">
                        <?php echo Language::lang('Global.index.header.category_tests', $category); ?>
                    </div>
                    <div class="card-body">
                        <?php
                            foreach ($classes as $test) {
                                ?>
                            <div class="row" style="padding: 10px 0px;">
                                <div class="col-md-8">
                                    <h4 class="card-title"><?php echo $test['name']; ?></h4>
                                </div>
                                <div class="col-md-4">
                                    <a href="run.php?test=<?php echo $test['class']; ?>" class="btn btn-primary float-right"><?php echo Language::lang('Global.index.button.execute_test'); ?></a>
                                </div>
                            </div>
                        <?php
                            } ?>
                    </div>
                </div>
            <?php
                    }
                }
            ?>
        </div>
    </main>
<?php @require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
