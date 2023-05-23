<?php    
    include('include_headers.php');                                 
?>  
<body class="fix-header fix-sidebar card-no-border">
   <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="text-info"><i class="ti-lock"></i></h1>
                <h2 class="text-uppercase text-danger">No User Session Found!</h2>
                <p class="m-t-30 m-b-30">Add Your Text Here</p>
                <!-- <a href="https://www.nct.edu.om/eservices/index.php" title="Click to Proceed to NCT E-Services Login Page." class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Proceed to NCT E-Services Login page <i class="fa fa-paper-plane"></i></a> -->
                <a href="login.php" title="Click to Proceed to NCT E-Services Login Page." class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Proceed to NCT E-Services Login page <i class="fa fa-paper-plane"></i></a>
            </div>
   
        </div>
    </section>
    <?php
        include('include_scripts.php');
    ?>
</body>
</html>