<!DOCTYPE html>
<html>

<head>
    <title>Error!</title>
    <style>
        <?php

        use App\Core\Helpers\FileHelper;

        include 'style.css'
        ?>
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-title-container">
            <h5>
                <b>
                    <?php
                    echo get_class($exception);
                    echo '<br/>';
                    echo 'CODE: ' . $exception->getCode() ?>
                </b>
            </h5>
            <h1>
                <?php echo $exception->getMessage() ?>
            </h1>
            <h2>
                <?php echo \App\Core\Helpers\StringHelper::getFileNameFromPath($exception->getFile(), '.php') ?>
                -
                <?php echo $exception->getLine() ?>
            </h2>
        </div>

        <!-- Tab links -->
        <div class="tab">
            <a class="tabLinks" onclick="openHorizontalTab(event, 'Stacktrace')">Stacktrace</a>
            <a class="tabLinks" onclick="openHorizontalTab(event, 'Code')" id="defaultOpen">Code</a>
            <a class="tabLinks" onclick="openHorizontalTab(event, 'FullTrace')">Raw Trace</a>
        </div>

        <!-- Tab content -->
        <div id="Stacktrace" class="tabContent">
            <div class="error-content-container">
                <div class="error-content-container-errors">
                    <?php
                    echo '<div class="error-info">';
                    echo '<a class="line">' . $exception->getLine() . '</a>';
                    echo '<br/>';
                    echo '<a class="file">' . $exception->getFile() . '</a>';
                    $content = file($exception->getFile());
                    $line = $exception->getLine() - 1;

                    $start = $line - 5 < 0 ? 0 : $line - 5;
                    $end = $line + 5 > count($content) ? count($content) : $line + 5;

                    echo '<pre>';
                    for ($i = $start; $i < $end; $i++) {
                        if ($i === $line) {
                            echo "<span> $content[$i] </span";
                        } else {
                            echo $content[$i];
                        }
                    }
                    echo '</pre>';
                    echo '</div>';

                    foreach ($exception->getTrace() as $trace) {
                        echo '<div class="error-info">';
                        echo '<a class="function">' . $trace['function'] . ' - ' . '</a>' . '<a class="line">' . $trace['line'] . '</a>';
                        echo '<br/>';
                        echo '<a class="file">' . $trace['file'] . '</a>';
                        $content = file($trace['file']);
                        $line = $trace['line'] - 1;

                        $start = $line - 5 < 0 ? 0 : $line - 5;
                        $end = $line + 5 > count($content) ? count($content) : $line + 5;

                        echo '<pre>';
                        for ($i = $start; $i < $end; $i++) {
                            if ($i === $line) {
                                echo "<span> $content[$i] </span";
                            } else {
                                echo $content[$i];
                            }
                        }
                        echo '</pre>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div id="Code" class="tabContent">
            <div class="error-content-container">
                <div class="error-content-container-errors">
                    <?php
                    $content = file($exception->getFile());
                    $line = $exception->getLine() - 1; // -1 because file() starts at 0

                    $start = $line - 10 < 0 ? 0 : $line - 10;
                    $end = $line + 10 > count($content) ? count($content) : $line + 10;

                    echo '<pre>';
                    for ($i = $start; $i < $end; $i++) {
                        if ($i === $line) {
                            echo '<span>';
                        }

                        echo $content[$i];

                        if ($i === $line) {
                            echo '</span>';
                        }
                    }
                    echo '</pre>';
                    ?>
                </div>
            </div>
        </div>

        <div id="FullTrace" class="tabContent">
            <div class="error-content-container">
                <div class="error-content-container-errors">
                    <?php
                    foreach ($exception->getTrace() as $trace) {
                        foreach ($trace as $key => $traceInfo) {
                            echo '<b>[' . $key . ']</b> : ';
                            if (is_array($traceInfo)) {
                                var_dump($traceInfo);
                            } else {
                                echo '<a>' . $traceInfo . '</a>';
                            }
                            echo '<br/>';
                        }
                        echo '<br/>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        const openHorizontalTab = (evt, tabName) => {
            const tabContent = document.querySelectorAll(".tabContent");
            const tabLinks = document.querySelectorAll(".tablinks");

            tabContent.forEach((value, key) => {
                value.style.display = "none";
            });

            tabLinks.forEach((value, key) => {
                value.className = value.className.replace(" active", "");
            });

            document.querySelector('#' + tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        document.getElementById("defaultOpen").click();
    </script>
</body>

</html>
