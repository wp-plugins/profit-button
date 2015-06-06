<?php
header("content-type: application/javascript");
?>

<?php
    //error_reporting(E_ALL);

    function checkParamExist($paramName="", $paramKey="") {
        if ((isset($_GET[$paramKey])) && ($_GET[$paramKey]!="")) {
            return '\''.$paramName.'\': '.'\''.$_GET[$paramKey].'\',';
        } else {
            return "";
        }
    }
?>

<?php
if (!isset($_GET['state']) || $_GET['state']=="on" || $_GET['state']=='') {
?>
    FloatingButtonFunc();
<?php
};

$source = 0; //probtn.com
if (!isset($_GET['source']) || $_GET['source']=="probtn.com" || $_GET['source']=='') {
} else {
    $source = 1;
};
?>

function FloatingButtonFunc() {    

    var mainStyleCssPath = "//cdn.probtn.com/style.css";
    var jquerypepPath =  "//cdn.probtn.com/libs/jquery.pep.min.js";
    var fancyboxPath = "//cdn.probtn.com/libs/jquery.fancybox.min.js";
    var fancyboxCssPath = "//cdn.probtn.com/libs/jquery.fancybox.min.css";
    var probtnPath = "//cdn.probtn.com/probtn.js";
    var jqueryPath = '//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js';
    var isServerCommunicationEnabled = true;
    var useLocalFileSettings = false;
    var localSettingsPath = "settings.json";
    var isHPMD = false;
    var domain = 'wordpress.plugin';
    try {
        window.probtn_hpmd = hpmd;
    } catch(ex) {
        window.probtn_hpmd = null;
    }

    var loadProbtn = function() {
        jQuery.getScript(probtnPath, function () {
            jQuery(document).StartButton({            
                isHPMD: isHPMD,
                hpmd: window.probtn_hpmd,
                domain: domain,
                
                mainStyleCss: mainStyleCssPath,
                fancyboxCssPath: fancyboxCssPath,
                fancyboxJsPath: fancyboxPath,
                jqueryPepPath: jquerypepPath,
                <?php
                if ($source==1) {
                ?>
                    <?php echo checkParamExist("ButtonImage","probtn_image") ?>
                    <?php echo checkParamExist("ButtonDragImage","probtn_image") ?>
                    <?php echo checkParamExist("ButtonOpenImage","probtn_image") ?>
                    <?php echo checkParamExist("ButtonInactiveImage","probtn_image") ?>
                    <?php echo checkParamExist("ContentURL","probtn_contenturl") ?>
                    <?php echo checkParamExist("HintText","probtn_hinttext") ?>
                <?php
                }
                ?>
            })
        })
    }

    var loadFancybox = function () {
        var fancyboxFunction = null;
        try {
            fancyboxFunction = jQuery.fancybox;
        } catch (ex) {
        }

        if (typeof fancyboxFunction == 'function') {
            loadProbtn();
        } else {
            jQuery.getScript(fancyboxPath, function () {
                loadProbtn();
            })
        }
    }

    var loadJqueryPep = function () {
        var pepFunction = null;
        try {
            pepFunction = jQuery.pep.toggleAll;
        } catch (ex) { }

        if (typeof pepFunction == 'function') {
            loadFancybox();
        } else {
            jQuery.getScript(jquerypepPath, function() {
                loadFancybox();
            })
        }
    }

    if (window.jQuery) {
        console.log("Is jquery");
        if ($ == jQuery) {
            //console.log(1);
            //jQuery(document).ready(function () {
                loadJqueryPep();
            //})
        } else {
            console.log(2);
            var oHead = document.getElementsByTagName('HEAD').item(0);

            var oScript = document.createElement("script");
            oScript.type = "text/javascript";
            oScript["data-cfasync"] = "false";
            oScript.text = "jQuery.noConflict(); jQuery.getScript('" + jquerypepPath + "', function() { jQuery.getScript('" + fancyboxPath + "', function () { jQuery.getScript('" + probtnPath + "', function () { jQuery(document).StartButton({'hpmd': window.probtn_hpmd, 'domain': '" + domain + "', 'fancyboxCssPath': '" +fancyboxCssPath +"', 'isHPMD': " + isHPMD + ", 'mainStyleCss':'" + mainStyleCssPath + "', <?php
if ($source==1) {
?>
    <?php echo checkParamExist("ButtonImage","probtn_image") ?>
    <?php echo checkParamExist("ButtonDragImage","probtn_image") ?>
    <?php echo checkParamExist("ButtonOpenImage","probtn_image") ?>
    <?php echo checkParamExist("ButtonInactiveImage","probtn_image") ?>
    <?php echo checkParamExist("ContentURL","probtn_contenturl") ?>
    <?php echo checkParamExist("HintText","probtn_hinttext") ?>
<?php
}
?> });});});}); ";
            oHead.appendChild(oScript);
        }
    } else {
        console.log("No jquery");
        var oHead = document.getElementsByTagName('HEAD').item(0);

        function loadJS(src, callback) {
            var s = document.createElement('script');
            s.src = src;
            s["data-cfasync"] = "false";
            s.async = true;
            s.onreadystatechange = s.onload = function () {
                var state = s.readyState;
                if (!callback.done && (!state || /loaded|complete/.test(state))) {
                    callback.done = true;
                    callback();
                }
            };
            document.getElementsByTagName('head')[0].appendChild(s);
        }
        loadJS(jqueryPath, function () {
            var oScript = document.createElement("script");
            oScript.type = "text/javascript";
            oScript["data-cfasync"] = "false";
            oScript.text = "(function ($) {jQuery.noConflict(); jQuery.getScript('" + jquerypepPath + "', function() {jQuery.getScript('" + fancyboxPath + "', function () {jQuery.getScript('" + probtnPath + "', function () { jQuery(document).StartButton({'hpmd': window.probtn_hpmd, 'domain': '" + domain + "',  'fancyboxCssPath': '" + fancyboxCssPath + "', 'isHPMD': " + isHPMD + ", 'mainStyleCss': '" + mainStyleCssPath + "', <?php
if ($source==1) {
?>
    <?php echo checkParamExist("ButtonImage","probtn_image") ?>
    <?php echo checkParamExist("ButtonDragImage","probtn_image") ?>
    <?php echo checkParamExist("ButtonOpenImage","probtn_image") ?>
    <?php echo checkParamExist("ButtonInactiveImage","probtn_image") ?>
    <?php echo checkParamExist("ContentURL","probtn_contenturl") ?>
    <?php echo checkParamExist("HintText","probtn_hinttext") ?>
<?php
}
?>}); })});}); })(window.jQuery);";
            //setTimeout(function() {oHead.appendChild( oScript) }, 100);
            oHead.appendChild(oScript);
        });
    }
}
