<?php
    // Initialize the bootstraping operations
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

    // Execute given test
    if (isset($_GET['test']) && class_exists($_GET['test'])) {
        $instance_class = trim($_GET['test']);

        try {
            $class_test = new $instance_class();
            $class_test->test();

            // Get requested data
            $request = (array) $class_test->request;

            // Get test data
            $status = $class_test->getStatus();
            $result = $class_test->getOutput();
            $input = $class_test->getInput();
            $instance = $class_test->instance;
        } catch (Exception $e) {
            $status = false;
            $result = $e;
        }
    }

    // Redirect if the results are empty
    if (empty($class_test)) {
        header('Location: index.php');
    }
?>

<?php @require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading"><?php echo Language::lang('Global.run.heading'); ?></h1>
                <p class="lead text-muted"><?php echo Language::lang('Global.run.sub_title'); ?></p>
                <p>
                    <a href="run.php?test=<?php echo $_GET['test']; ?>" class="btn btn-primary"><?php echo Language::lang('Global.run.button.execute_again'); ?></a>
                    <a href="index.php" class="btn btn-secondary"><?php echo Language::lang('Global.run.button.back'); ?></a>
                </p>
            </div>
        </section>
        <div class="container">
            <?php
                if ($status) {
                    ?>
                <div class="text-success" style="padding-bottom: 20px;">
                    <h3><i class="fas fa-check-circle"></i> <?php echo Language::lang('Global.run.alert.success_test'); ?></h3>
                </div>
            <?php
                } else {
                    ?>
                <div class="text-danger" style="padding-bottom: 20px;">
                    <h3><i class="fas fa-times-circle"></i> <?php echo Language::lang('Global.run.alert.fail_test'); ?></h3>
                </div>
            <?php
                }
            ?>

            <?php 
                if (!empty($request) && is_array($request)) {
                    ?>
                <div class="card" style="margin-bottom: 25px;">
                    <div class="card-header">
                        <?php echo Language::lang('Global.run.header.input_parameters', $_GET['test']); ?>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <?php
                                foreach ($request as $key => $value) {
                                    ?>
                                <div class="input-group" style="margin-bottom: 10px;" id="param_<?php echo $key; ?>">
                                    <span class="input-group-addon"><?php echo $key; ?></span>
                                    <input type="text" class="form-control" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
                                    <span class="input-group-btn">
                                        <a href="#" onclick="$('#param_<?php echo $key; ?>').remove();" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> <?php echo Language::lang('Global.run.button.delete'); ?>
                                        </a>
                                    </span>
                                </div>
                            <?php
                                } ?>
                            <small><?php echo Language::lang('Global.run.text.custom_call_notice'); ?></small>

                            <div class="float-right">
                                <button class="btn btn-primary btn-sm" type="submit"><?php echo Language::lang('Global.run.button.execute_custom'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
                }
            ?>
            
            <div class="card">
                <div class="card-header">
                    <?php echo Language::lang('Global.run.header.test_result', $_GET['test']); ?>
                </div>
                <div class="card-body">
                    <?php
                        if (isset($instance)) {
                            $instance_name = @get_class($instance);
                            if (!empty($instance_name)) {
                                ?>
                        <h5><?php echo Language::lang('Global.run.header.class', $instance_name); ?></h5>
                        <pre><?php print_r($instance); ?></pre>
                        <hr>
                    <?php
                            }
                        }
                    ?>
                    <h5><?php echo Language::lang('Global.run.header.class', $_GET['test']); ?></h5>
                    <pre><?php print_r($class_test); ?></pre>
                    <hr>
                        
                    <h5><?php echo Language::lang('Global.run.header.test_input', $_GET['test']); ?></h5>
                    <pre><?php print_r($input); ?></pre>
                    <hr>
                   
                    <h5><?php echo Language::lang('Global.run.header.test_result', $_GET['test']); ?></h5>
                    <pre><?php print_r($result); ?></pre>
                </div>
            </div>
        </div>
    </main>
<?php @require __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
