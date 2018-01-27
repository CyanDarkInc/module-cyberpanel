<?php
    // Initialize the bootstraping operations
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

    // Execute all the tests
    $results = [];
    foreach ($available_tests as $classes) {
        foreach ($classes as $test) {
            try {
                $class_test = new $test['class']();
                $class_test->test();

                $status = $class_test->getStatus();
                $result = $class_test->getOutput();
                $input = $class_test->getInput();

                $results[$test['class']] = $status;
            } catch (Exception $e) {
                $results[$test['class']] = false;
            }
        }
    }

    // Redirect if the results are empty
    if (empty($results)) {
        header('Location: index.php');
    }
?>

<?php @require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading"><?php echo Language::lang('Global.all.heading'); ?></h1>
                <p class="lead text-muted"><?php echo Language::lang('Global.all.sub_title'); ?></p>
                <p>
                    <a href="all.php" class="btn btn-primary"><?php echo Language::lang('Global.all.button.execute_again'); ?></a>
                    <a href="index.php" class="btn btn-secondary"><?php echo Language::lang('Global.all.button.back'); ?></a>
                </p>
            </div>
        </section>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <?php echo Language::lang('Global.all.header.test_results'); ?>
                </div>
                <div class="card-body">
                    <?php
                        if (!empty($results)) {
                            foreach ($results as $name => $status) {
                                ?>
                        <div class="row" style="padding: 10px 0px;">
                            <div class="col-md-8">
                                <h4 class="card-title"><?php echo $name; ?></h4>
                                <?php
                                    if ($status) {
                                        ?>
                                    <strong class="text-success"><i class="fas fa-check-circle"></i> <?php echo Language::lang('Global.all.alert.success_test'); ?></strong>
                                <?php
                                    } else {
                                        ?>
                                    <strong class="text-danger"><i class="fas fa-times-circle"></i> <?php echo Language::lang('Global.all.alert.fail_test'); ?></strong>
                                <?php
                                    } ?>
                            </div>
                            <div class="col-md-4">
                                <a href="run.php?test=<?php echo $name; ?>" class="btn btn-primary float-right"><?php echo Language::lang('Global.all.button.view_test'); ?></a>
                            </div>
                        </div>
                    <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
<?php @require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>

