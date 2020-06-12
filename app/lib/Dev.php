<?php

function dump($data){
    $s = var_export($data, true);
    echo '<h4>';
    highlight_string("<?php " . $s . " ?>");
    echo '</h4>';
    echo '<script>
            document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove();
            document.getElementsByTagName("code")[0].getElementsByTagName("span")[
                document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1
                ].remove();
        </script>';
}

function edump($data){
    $s = var_export($data, true);
    echo '<h4>';
    highlight_string("<?php " . $s . " ?>");
    echo '</h4>';
    echo '<script>
            document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove();
            document.getElementsByTagName("code")[0].getElementsByTagName("span")[
                document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1
                ].remove();
        </script>';
    die;
}