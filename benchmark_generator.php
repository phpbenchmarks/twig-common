<?php

function writeFunctionsFile()
{
    $functionsFile = fopenPhpFile('functions.php');

    for ($i = 1; $i <= 100; $i++) {
        $code = <<<CODE
/**
 * @param int \$index
 * @return string
 */
function overloadFunction$i(\$index)
{
    echo '[#' . \$index . '] PHP Benchmarks overload function';
}


CODE;

        fwrite($functionsFile, $code);
    }
    fclose($functionsFile);
}

/** @return string */
function getCustomFunctionCallPhpCode()
{
    $return = <<<CODE
        <?php
        // -------------------------------------------------------------------------------------------------------------
        // Create 100 custom functions and call them all
        // -------------------------------------------------------------------------------------------------------------

        require __DIR__ . '/../overload/functions.php';
        ?>

        <div class="row">
            <div class="col-md-12">
                <h1>Create 100 custom functions and call them all</h1>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Function call</th>
                        </tr>
                    </thead>
                    <tbody>

CODE;

    for ($i = 1; $i <= 100; $i++) {
        $return .= <<<CODE
                        <tr>
                            <td>#$i</td>
                            <td><?php overloadFunction$i($i) ?></td>
                        </tr>

CODE;
    }

    $return .= <<<CODE
                    </tbody>
                </table>
            </div>
        </div>
CODE;

    return $return;
}

function writeMacrosFile()
{
    $macrosFile = fopen(__DIR__ . '/templates/macros.html.twig', 'w');

    for ($i = 1; $i <= 100; $i++) {
        $code = <<<CODE
{% macro overloadMacro$i(index) %}
    [#{{ index }}] PHP Benchmarks overload macro
{% endmacro %}


CODE;
        fwrite($macrosFile, $code);
    }
    fclose($macrosFile);
}

/** @return string */
function getMacroCallPhpCode()
{
    $return = <<<CODE
    {# ---------------------------------------------------------------------------------------------------------- #}
    {# Create 100 macros and call them all #}
    {# ---------------------------------------------------------------------------------------------------------- #}

    {% import 'macros.html.twig' as overloadMacros %}
    ?>

    <div class="row">
        <div class="col-md-12">
            <h1>Create 100 macros and call them all</h1>
            <table class="table table-striped table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Macro call</th>
                    </tr>
                </thead>
                <tbody>

CODE;

    for ($i = 1; $i <= 100; $i++) {
        $return .= <<<CODE
                    <tr>
                        <td>#$i</td>
                        <td>{{ overloadMacros.overloadMacro$i($i) }}</td>
                    </tr>

CODE;
    }

    $return .= <<<CODE
                </tbody>
            </table>
        </div>
    </div>
CODE;

    return $return;
}

function writeBlocksFile()
{
    $blocksFile = fopenPhpFile('blocks.php');

    for ($i = 1; $i <= 50; $i++) {
        $code = <<<CODE
/** @param int \$index */
function overloadBlock$i(\$index)
{
    echo '[#' . \$index . '] PHP Benchmarks overload block';
}


CODE;

        fwrite($blocksFile, $code);
    }
    fclose($blocksFile);
}

/** @return string */
function getHtmlEscapingPhpCode()
{
    $return = <<<CODE
        <?php
        // -------------------------------------------------------------------------------------------------------------
        // Escape 500 strings for HTML, and echo them all
        // -------------------------------------------------------------------------------------------------------------
        ?>
        <div class="row">
            <div class="col-md-12">
                <h1>Echo 500 strings escaped for HTML</h1>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Escaped string</th>
                        </tr>
                    </thead>
                    <tbody>

CODE;

    for ($i = 1; $i <= 500; $i++) {
        $return .= <<<CODE
                        <tr>
                            <td>#$i</td>
                            <td><?php echo htmlentities('<a href="http://www.phpbenchmarks.com">[#$i] PHP Benchmarks (HTML escaping)</a>') ?></td>
                        </tr>

CODE;
    }

    $return .= <<<CODE
                    </tbody>
                </table>
            </div>
        </div>
CODE;

    return $return;
}

/** @return string */
function getJavascriptEscapingPhpCode()
{
    $return = <<<CODE
        <?php
        // -------------------------------------------------------------------------------------------------------------
        // Escape 500 strings for Javascript
        // -------------------------------------------------------------------------------------------------------------

        // Taken from Twig javascript escaping
        /**
         * @param string \$string
         * @return string
         */
        function javascriptentities(\$string)
        {
            \$return = preg_replace_callback(
                '#[^a-zA-Z0-9,\._]#Su',
                function (\$matches) {
                    \$char = \$matches[0];
            
                    // \xHH
                    if (!isset(\$char[1])) {
                        return '\\x'.strtoupper(substr('00'.bin2hex(\$char), -2));
                    }
            
                    // \uHHHH
                    \$char = strtoupper(bin2hex(\$char));
            
                    if (4 >= strlen(\$char)) {
                        return sprintf('\u%04s', \$char);
                    }
            
                    return sprintf('\u%04s\u%04s', substr(\$char, 0, -4), substr(\$char, -4));
                }, 
                \$string
            );
            
            return \$return;
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <h1>Echo 500 strings escaped for Javascript</h1>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Escaped string</th>
                        </tr>
                    </thead>
                    <tbody>

CODE;

    for ($i = 1; $i <= 500; $i++) {
        $return .= <<<CODE
                        <tr>
                            <td>#$i</td>
                            <td id="escapedStringForJs$i"></td>
                        </tr>

CODE;

    }

    $return .= <<<CODE
                    </tbody>
                </table>
                <script type="text/javascript">

CODE;

    for ($i = 1; $i <= 500; $i++) {
        $return .= <<<CODE
                    var escapedStringForJs$i = '<?php echo javascriptentities('<a href="http://www.phpbenchmarks.com">[#$i] PHP Benchmarks (JS escaping)</a>') ?>';
                    document.getElementById('escapedStringForJs$i').innerHTML = escapedStringForJs$i;

CODE;
    }

    $return .= <<<CODE
                </script>
            </div>
        </div>

CODE;

    return $return;
}

/** @return string */
function getEchoHtmlVarPhpCode()
{
    $return = <<<CODE
        <?php
        // -------------------------------------------------------------------------------------------------------------
        // Assign HTML string to 100 vars and echo them all (to use raw filter in template engines)
        // -------------------------------------------------------------------------------------------------------------
        ?>

        <div class="row">
            <div class="col-md-12">
                <h1>Echo 100 vars with HTML (to use raw filter in template engine)</h1>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Escaped string</th>
                        </tr>
                    </thead>
                    <tbody>

CODE;

    for ($i = 1; $i <= 100; $i++) {
        $return .= <<<CODE
                        <tr>
                            <td>#$i</td>
                            <td>
                                <?php
                                \$rawHtml$i = '<a href="http://www.phpbenchmarks.com">[#$i] PHP Benchmarks (raw filter)</a>';
                                echo \$rawHtml$i;
                                ?>
                            </td>
                        </tr>

CODE;
    }

    $return .= <<<CODE
                    </tbody>
                </table>
            </div>
        </div>
CODE;


    return $return;
}

/** @return string */
function getEchoUnknownVarPhpCode()
{
    $return = <<<CODE
        <?php
        // -------------------------------------------------------------------------------------------------------------
        // Echo 100 unknown vars
        // -------------------------------------------------------------------------------------------------------------
        ?>

        <div class="row">
            <div class="col-md-12">
                <h1>Echo 100 unknown vars</h1>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Unkonwn value</th>
                        </tr>
                    </thead>
                    <tbody>

CODE;

    for ($i = 1; $i <= 100; $i++) {
        $return .= <<<CODE
                        <tr>
                            <td>$i</td>
                            <td><?php echo isset(\$unknownVar$i) ? \$unknownVar$i : 'Unknown var $i' ?></td>
                        </tr>

CODE;
    }

    $return .= <<<CODE
                    </tbody>
                </table>
            </div>
        </div>
CODE;

    return $return;
}

/** @return string */
function getEchoMethodCallPhpCode()
{
    $return = <<<CODE
        <?php
        // -------------------------------------------------------------------------------------------------------------
        // Echo 500 calls to an object method
        // -------------------------------------------------------------------------------------------------------------

        class OverloadObject
        {
            /** @return string */
            public function phpBenchmarks()
            {
                return 'PHP Benchmarks';
            }
        }
        \$overloadObject = new OverloadObject();
        ?>
        <div class="row">
            <div class="col-md-12">
                <h1>Echo 500 calls to an object method</h1>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>OverloadObject::phpBenchmarks() call</th>
                        </tr>
                    </thead>
                    <tbody>

CODE;

    for ($i = 1; $i <= 500; $i++) {
        $return .= <<<CODE
                        <tr>
                            <td>$i</td>
                            <td><?php echo \$overloadObject->phpBenchmarks() ?></td>
                        </tr>

CODE;
    }

    $return .= <<<CODE
                    </tbody>
                </table>
            </div>
        </div>
CODE;

    return $return;
}

function writeTemplatesToInclude()
{
    for ($i = 1; $i <= 50; $i++) {
        $templateFile = fopenPhpFile('templates/template' . $i . '.php', false);
        $php = <<<CODE
                        <tr>
                            <td>#$i</td>
                            <td><?php echo \$template$i ?></td>
                        </tr>

CODE;
        fwrite($templateFile, $php);
        fclose($templateFile);
    }
}

/** @return string */
function getIncludeTemplatePhpCode()
{
    $return = <<<CODE
        <?php
        // -------------------------------------------------------------------------------------------------------------
        // Include 50 templates
        // -------------------------------------------------------------------------------------------------------------
        ?>

        <div class="row">
            <div class="col-md-12">
                <h1>Include 50 templates</h1>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Template parameter value</th>
                        </tr>
                    </thead>
                    <tbody>

CODE;

    for ($i = 1; $i <= 50; $i++) {
        $return .= <<<CODE
                        <?php
                        \$template$i = '[#$i] PHP Benchmarks';
                        include(__DIR__ . '/../overload/templates/template$i.php');
                        unset(\$template$i);
                        ?>

CODE;
    }

    $return .= <<<CODE
                    </tbody>
                </table>
            </div>
        </div>
CODE;

    return $return;
}

function writeLayoutFile()
{
    $code = <<<CODE
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <title>Small overload benchmark</title>
    </head>
    <body>
        {# ---------------------------------------------------------------------------------------------------------- #}
        {# Create 50 blocks and fill them all
        {# ---------------------------------------------------------------------------------------------------------- #}
        <div class="row">
            <div class="col-md-12">
                <h1>Create 50 blocks and fill them all</h1>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Block content</th>
                        </tr>
                    </thead>
                    <tbody>

CODE;

    for ($i = 1; $i <= 50; $i++) {
        $code .= <<<CODE
                        <tr>
                            <td>#$i</td>
                            <td>{% block overloadBlock$i '' %}</td>
                        </tr>

CODE;
    }

    $code .= <<<CODE
                    </tbody>
                </table>
            </div>
        </div>
        
        {% block body '' %}
    </body>
</html>

CODE;

    file_put_contents(__DIR__ . '/templates/layout.html.twig', $code);

}

function writeTemplatingSmallOverloadFile()
{
//    $customFunctionCallPhpCode = getCustomFunctionCallPhpCode();
    $macrosCallPhpCode = getMacroCallPhpCode();
//    $htmlEscapingPhpCode = getHtmlEscapingPhpCode();
//    $javascriptEscapingPhpCode = getJavascriptEscapingPhpCode();
//    $echoHtmlVarPhpCode = getEchoHtmlVarPhpCode();
//    $echoUnkownVarPhpCode = getEchoUnknownVarPhpCode();
//    $echoMethodCallPhpCode = getEchoMethodCallPhpCode();
//    $includeTemplatePhpCode = getIncludeTemplatePhpCode();


    $twig = <<<CODE
{# This code has to fill OPCache, so we will not use loop and write duplicated code #}

{% extends 'layout.html.twig' %}

{% block body %}

$macrosCallPhpCode

{% endblock %}

CODE;

    file_put_contents(__DIR__ . '/templates/templatingSmallOverload.html.twig', $twig);
}

//writeFunctionsFile();
writeMacrosFile();
//writeBlocksFile();
//writeTemplatesToInclude();
writeLayoutFile();
writeTemplatingSmallOverloadFile();
