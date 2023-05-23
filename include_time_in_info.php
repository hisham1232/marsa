<div class="col-md-7 col-4 align-self-center">
    <div class="d-flex m-t-10 justify-content-end">
        <div class="d-flex m-r-20 m-l-10 hidden-md-down">
            <div class="chart-text m-r-10">
                <?php
                    $ngayonDate = date("Y-m-d",time());
                    $getTimeIn = new DbaseManipulation;
                    //$row = $getTimeIn->singleReadFullQry("SELECT TOP 1 * FROM v_attendance WHERE StaffId = '$staffId' AND Date = '$ngayonDate' ORDER BY Date DESC");
                    $row = $getTimeIn->singleReadFullQry("SELECT TOP 1 inTime FROM fpuserlog WHERE userid = '$staffId' AND recordDate = '$ngayonDate' ORDER BY recordDate DESC");
                    if($getTimeIn->totalCount != 0) {
                        $oras = date('h:i:s A',strtotime($row['inTime']));
                    } else {
                        $oras = "<span class='text-danger'>No Time-in Found!</span>";
                    }
                ?>
                <h6 class="m-b-0"><small><?php echo date("l, F d, Y",time()); ?></small></h6>
                <h6 class="m-b-0"><small>Your Today's Time In</small></h6>
                <h4 class="m-t-0 text-primary"><?php echo $oras; ?></h4>
            </div>
            <div class="spark-chart">
                <i class="far fa-clock fa-3x text-primary"></i>
            </div>
        </div>
    </div>
</div>