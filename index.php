<?php
require 'config.php';
?>
<a href="https://accounts.google.com/o/oauth2/v2/auth?scope=email&access_type=online&include_granted_scopes=true&response_type=code&state=state_parameter_passthrough_value&redirect_uri=<?=urlencode('http://localhost:8000/connect.php')?>&client_id=<?=GOOGLE_ID?>">vous connectez a google</a>