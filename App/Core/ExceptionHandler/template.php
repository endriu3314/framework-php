<!DOCTYPE html>
<html>
<head>
    <title>Error!</title>
    <style>
        <?php include "style.css" ?>
    </style>
</head>

<body>
<div class="error-container">
    <div class="error-title-container">
        <h1>
            <?php echo $exception->getMessage() ?>
        </h1>
        <h2>
            <?php echo \App\Helpers\StringHelper::getFileNameFromPath($exception->getFile(), '.php') ?>
            -
            <?php echo $exception->getLine() ?>
        </h2>
    </div>

    <!-- Tab links -->
    <div class="tab">
        <a class="tabLinks" onclick="openHorizontalTab(event, 'Stacktrace')" id="defaultOpen">Stacktrace</a>
        <a class="tabLinks" onclick="openHorizontalTab(event, 'Code')">Code</a>
        <a class="tabLinks" onclick="openHorizontalTab(event, 'FullTrace')">Full Trace</a>
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
                echo '</div>';
                ?>
                <?php
                foreach ($exception->getTrace() as $trace) {
                    echo '<div class="error-info">';
                    echo '<a class="function">' . $trace["function"] . ' - ' . '</a>' . '<a class="line">' . $trace["line"] . '</a>';
                    echo '<br/>';
                    echo '<a class="file">' . $trace["file"] . '</a>';
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
                $file = fopen($exception->getFile(), "r");

                //array starts from 0, when reading file we want to start from 1
                $fileArray = ['']; //default value to do +1 to index

                while (!feof($file)) {
                    $fileArray[] = fgets($file) . "<br>";
                }

                $lines = 3;
                $start = $exception->getLine() - $lines;

                if ($start < 0) {
                    echo "There was an error, starting from top of file";
                    $start = 0;
                }

                fclose($file);
                echo '<pre>';
                echo '<code>';
                for ($i = $start; $i >= 0 && $i <= $exception->getLine() + $lines; $i++) {
                    if ($i >= count($fileArray))
                        break;

                    if ($i < 10) echo $i . '  ';
                    else echo $i . ' ';

                    $style = $i == $exception->getLine() ? 'background-color: #FC8181' : 'background-color: none';
                    echo '<a style="' . $style . '">' . $fileArray[$i] . '</a>';
                }
                echo '</code>';
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
                        }
                        else echo '<a>' . $traceInfo . '</a>';
                        echo '<br/>';
                    }
                    echo '<br/>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/App/Core/ExceptionHandler/index.js"></script>
</body>
</html>
