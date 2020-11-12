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
        <a class="tabLinks" onclick="openHorizontalTab(event, 'Stacktrace')">Stacktrace</a>
        <a class="tabLinks" onclick="openHorizontalTab(event, 'Code')" id="defaultOpen">Code</a>
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
                $fileContent = \App\Core\ExceptionHandler\ExceptionHandler::getFileContentArrayFromPath($exception->getFile());
                echo '<b>' . \App\Helpers\StringHelper::getFileNameFromPath($exception->getFile()) . '</b>';
                echo '<br/>';
                echo '<sm>' . $exception->getFile() . '</sm>';
                echo '<pre class="code" style="">';
                echo '<code>';
                \App\Core\ExceptionHandler\ExceptionHandler::printFileLinesFromArray($fileContent, $exception, 5);
                echo '</code>';
                echo '</pre>';
                echo '<br/>';

                foreach ($exception->getTrace() as $key => $trace) {
                    $fileContent = \App\Core\ExceptionHandler\ExceptionHandler::getFileContentArrayFromPath($trace["file"]);
                    echo '<b>' . \App\Helpers\StringHelper::getFileNameFromPath($trace["file"]) . ' - ' . $trace["line"] . '</b>';
                    echo '<br/>';
                    echo '<sm>' . $trace["file"] . '</sm>';
                    echo '<pre class="code" style="">';
                    echo '<code>';
                    \App\Core\ExceptionHandler\ExceptionHandler::printFileLinesFromArray($fileContent, $trace, 5, "array");
                    echo '</code>';
                    echo '</pre>';
                    echo '<br/>';
                }
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
                        } else echo '<a>' . $traceInfo . '</a>';
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
