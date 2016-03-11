
        <?php
        	require('./DatamuseAPI.php');
        	$test = \DatamuseAPI::means_like('ringing in the ears',15);
            echo json_encode($test);
        ?>

