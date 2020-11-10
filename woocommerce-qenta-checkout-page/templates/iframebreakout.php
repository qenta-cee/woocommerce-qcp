<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <style type="text/css">
        body {
            font-family: arial,helvetica,sans-serif;
        }

        h3 {
            color: #55555;
            font-size: 1.1em;
            font-weight: bold;
            margin: 20px 0 10px;
        }
    </style>
</head>
<body>
<h3><?php _e('You will be redirected shortly') ?></h3>
<p><?php _e('If not, please click <a href="#" onclick="iframeBreakout()">here</a>') ?></p>
<form method="POST" name="redirectForm" action="<?php echo $url; ?>" target="_parent">
    <input type="hidden" name="redirected" value="1" />
    <?php
    foreach ($_POST as $k => $v)
    {
        printf('<input type="hidden" name="%s" value="%s" />', htmlspecialchars($k), htmlspecialchars($v));
    }
    ?>
</form>
<script type="text/javascript">
    // <![CDATA[
    function iframeBreakout()
    {
        document.redirectForm.submit();
    }

    iframeBreakout();
    //]]>
</script>
</body>
</html>