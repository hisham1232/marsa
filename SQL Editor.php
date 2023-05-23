<?php

TRUNCATE TABLE dbhr3_test.staffresearch;
INSERT INTO dbhr3_test.staffresearch (staffId, category, title, subject, organization, location, startDate, endDate, abstract, attachment)
SELECT staffId, category, title, mainSubject, organization, location, startDate, endDate, abstract, attachment FROM dbhr.staffresearch;



CREATE TABLE staffpassport (
    id int(11) NOT NULL AUTO_INCREMENT,
    staffId varchar(15) NOT NULL,
    stafffamily_id int(11) NOT NULL,
    number varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
    issueDate date DEFAULT NULL,
    expiryDate date DEFAULT NULL,
    isFamilyMember varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
    isCurrent varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
    created datetime NOT NULL DEFAULT current_timestamp(),
    modified datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id,staffId,stafffamily_id),
    UNIQUE KEY id_UNIQUE (id),
    KEY fk_passport_staff1_idx (staffId),
    KEY fk_passport_stafffamily1_idx (stafffamily_id)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

   CREATE TABLE staffvisa (
    id int(11) NOT NULL AUTO_INCREMENT,
    staffId int(11) NOT NULL,
    stafffamily_id int(11) NOT NULL,
    civilId varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
    cExpiryDate date DEFAULT NULL,
    number varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
    issueDate date DEFAULT NULL,
    expiryDate date DEFAULT NULL,
    isFamilyMember varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
    isCurrent varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
    created datetime NOT NULL DEFAULT current_timestamp(),
    modified datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id,staffId,stafffamily_id),
    UNIQUE KEY id_UNIQUE (id),
    KEY fk_visa_stafffamily1_idx (stafffamily_id),
    KEY fk_visa_staff1_idx (staffId)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


   CREATE TABLE internalleavebalance (
    id int(11) NOT NULL AUTO_INCREMENT,
    requestNo varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
    sponsorType smallint(6) DEFAULT NULL,
    dateFiled datetime DEFAULT NULL,
    notes varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
    attachment varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
    isFinalized varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
    createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
    created datetime DEFAULT current_timestamp(),
    modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id),
    UNIQUE KEY id_UNIQUE (id)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


   CREATE TABLE internalleavebalancedetails (
    id int(11) NOT NULL AUTO_INCREMENT,
    internalleavebalance_id int(11) NOT NULL,
    leavetype_id int(11) NOT NULL,
    staff_id int(11) NOT NULL,
    startDate date DEFAULT NULL,
    endDate date DEFAULT NULL,
    total smallint(6) DEFAULT NULL,
    status varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
    notes varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
    addType smallint(6) DEFAULT NULL,
    createdBy varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
    created datetime DEFAULT current_timestamp(),
    modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id,internalleavebalance_id,leavetype_id,staff_id),
    UNIQUE KEY id_UNIQUE (id)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


   CREATE TABLE emergencyleavebalancedetails (
    id int(11) NOT NULL AUTO_INCREMENT,
    emergencyleavebalance_id varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    staffId varchar(11) COLLATE utf8_unicode_ci NOT NULL,
    startDate date DEFAULT NULL,
    endDate date DEFAULT NULL,
    total smallint(6) DEFAULT 0,
    status varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
    notes varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
    addType smallint(6) DEFAULT 1 COMMENT '1 - Reset (every Jan 1st for Ministry and 1st day of A.D. for Company); 2 - Added',
    createdBy varchar(11) COLLATE utf8_unicode_ci DEFAULT '',
    created datetime DEFAULT current_timestamp(),
    modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id,emergencyleavebalance_id,staffId),
    UNIQUE KEY id_UNIQUE (id)
   ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


   CREATE TABLE internalleavebalancedetails_draft (
    id int(11) NOT NULL AUTO_INCREMENT,
    internalleavebalance_id varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    leavetype_id int(11) NOT NULL,
    staffId varchar(11) COLLATE utf8_unicode_ci NOT NULL,
    startDate date DEFAULT NULL,
    endDate date DEFAULT NULL,
    total smallint(6) DEFAULT 0,
    status varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
    notes varchar(500) COLLATE utf8_unicode_ci DEFAULT '',
    addType smallint(6) DEFAULT 1,
    createdBy varchar(11) COLLATE utf8_unicode_ci DEFAULT '',
    created datetime DEFAULT current_timestamp(),
    modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id,internalleavebalance_id,leavetype_id,staffId),
    UNIQUE KEY id_UNIQUE (id)
   ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci



   CREATE TABLE emergencyleave (
    id int(11) NOT NULL AUTO_INCREMENT,
    requestNo varchar(15) COLLATE utf8_unicode_ci DEFAULT '',
    sponsorType smallint(6) DEFAULT 1 COMMENT '1 - All Ministry Staff; 2 - All Company Staff',
    dateFiled datetime DEFAULT current_timestamp(),
    notes varchar(500) COLLATE utf8_unicode_ci DEFAULT '',
    attachment varchar(500) COLLATE utf8_unicode_ci DEFAULT '',
    createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
    created datetime DEFAULT current_timestamp(),
    modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id),
    UNIQUE KEY id_UNIQUE (id)
   ) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci



   CREATE TABLE shortleave (
    id int(11) NOT NULL AUTO_INCREMENT,
    requestNo varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
    staff_id int(11) NOT NULL,
    currentStatus varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
    dateFile datetime DEFAULT NULL,
    leaveDate date DEFAULT NULL,
    startTime varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
    endTime varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
    total varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
    currentSeqNumber smallint(6) DEFAULT NULL,
    currentSeqId smallint(6) DEFAULT NULL,
    currentApproverId smallint(6) DEFAULT NULL,
    created datetime DEFAULT current_timestamp(),
    modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id,staff_id),
    UNIQUE KEY id_UNIQUE (id)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci






   CREATE TABLE approvalsequence_shortleave (
    id int(11) NOT NULL AUTO_INCREMENT,
    position_id int(11) NOT NULL,
    approver_in_sequence1 int(11) NOT NULL,
    approver_in_sequence2 int(11) NOT NULL,
    active int(11) NOT NULL,
    createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
    created datetime DEFAULT current_timestamp(),
    modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id,position_id),
    UNIQUE KEY id_UNIQUE (id)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


   CREATE TABLE approvalsequence_shortleave_history (
    id int(11) NOT NULL AUTO_INCREMENT,
    position_id int(11) NOT NULL,
    previous_approver int(11) NOT NULL,
    new_approver int(11) NOT NULL,
    active int(11) NOT NULL DEFAULT 1,
    notes varchar(1000) COLLATE utf8_unicode_ci DEFAULT '',
    createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
    created datetime DEFAULT current_timestamp(),
    modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id,position_id),
    UNIQUE KEY id_UNIQUE (id)
   ) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci



    CREATE TABLE shortleavehistory (
 id int(11) NOT NULL AUTO_INCREMENT,
 shortleave_id int(11) NOT NULL,
 staff_id int(11) NOT NULL,
 status varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
 notes varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
 ipAddress varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
 created datetime DEFAULT current_timestamp(),
 modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
 PRIMARY KEY (id,shortleave_id,staff_id),
 UNIQUE KEY id_UNIQUE (id),
 KEY fk_shortleavehistory_shortleave1_idx (shortleave_id),
 KEY fk_shortleavehistory_staff1_idx (staff_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci



    SELECT e.staff_id, e.joinDate, e.isCurrent, j.name as jobtitle, d.name as department, s.name as section, p.title as position, sp.name as sponsor
    FROM employmentdetail as e 
    LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id 
    LEFT OUTER JOIN department as d ON d.id = e.department_id 
    LEFT OUTER JOIN section as s ON s.id = e.section_id 
    LEFT OUTER JOIN staff_position as p ON p.id = e.position_id 
    LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id 
    WHERE e.staff_id = '499046'





    SELECT sh.*, d.name as department, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sp.name as sponsor FROM shortleave as sh 
    LEFT OUTER JOIN employmentdetail as e ON e.staff_id = sh.staff_id
    LEFT OUTER JOIN staff as s ON s.staffId = sh.staff_id
    LEFT OUTER JOIN department as d ON d.id = e.department_id
    LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
    WHERE sh.currentApproverPositionId = 18 AND sh.currentSeqNumber = 1 AND sh.currentStatus = 'Pending'
    ORDER BY sh.id DESC    

    SELECT sh.requestNo, sh.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName 
    FROM shortleave WHERE sh.currentApproverPositionId = 18 AND sh.currentSeqNumber = 1 AND sh.currentStatus = 'Pending'




    SELECT a.id, a.approverInSequence1, 
    concat(es.firstName,' ',es.secondName,' ',es.thirdName,' ',es.lastName) as approverName1, as1.title as sequence1, 
    a.approverInSequence2,
    concat(es2.firstName,' ',es2.secondName,' ',es2.thirdName,' ',es2.lastName) as approverName2, as2.title as sequence2, 
    a.approverInSequence3,
    concat(es3.firstName,' ',es3.secondName,' ',es3.thirdName,' ',es3.lastName) as approverName3, as3.title as sequence3,
    a.approverInSequence4,
    concat(es4.firstName,' ',es4.secondName,' ',es4.thirdName,' ',es4.lastName) as approverName4, as4.title as sequence4, 
    a.approverInSequence5,
    concat(es5.firstName,' ',es4.secondName,' ',es5.thirdName,' ',es5.lastName) as approverName5, as5.title as sequence5, 
    
    a.active, a.createdBy, a.created, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as createdBy 
    FROM approvalsequence_standardleave as a 
    LEFT OUTER JOIN department as d ON d.id = a.department_id 
    LEFT OUTER JOIN staff_position as p ON p.id = a.position_id 
    LEFT OUTER JOIN staff_position as as1 ON as1.id = a.approverInSequence1 
    LEFT OUTER JOIN staff_position as as2 ON as2.id = a.approverInSequence2 
    LEFT OUTER JOIN staff_position as as3 ON as3.id = a.approverInSequence3 
    LEFT OUTER JOIN staff_position as as4 ON as4.id = a.approverInSequence4 
    LEFT OUTER JOIN staff_position as as5 ON as5.id = a.approverInSequence5 
    LEFT OUTER JOIN staff as s ON s.staffId = a.createdBy 
    LEFT OUTER JOIN employmentdetail as e ON e.position_id = a.approverInSequence1
    LEFT OUTER JOIN staff as es ON es.staffId = e.staff_id
    LEFT OUTER JOIN employmentdetail as e2 ON e2.position_id = a.approverInSequence2
    LEFT OUTER JOIN staff as es2 ON es2.staffId = e2.staff_id
    LEFT OUTER JOIN employmentdetail as e3 ON e3.position_id = a.approverInSequence3
    LEFT OUTER JOIN staff as es3 ON es3.staffId = e3.staff_id
    LEFT OUTER JOIN employmentdetail as e4 ON e4.position_id = a.approverInSequence4
    LEFT OUTER JOIN staff as es4 ON es4.staffId = e4.staff_id
    LEFT OUTER JOIN employmentdetail as e5 ON e5.position_id = a.approverInSequence5
    LEFT OUTER JOIN staff as es5 ON es5.staffId = e5.staff_id

    WHERE a.position_id = 39 AND e.isCurrent = 1 AND e2.isCurrent = 1 AND e3.isCurrent = 1 AND e4.isCurrent = 1 AND e5.isCurrent = 1






    CREATE TABLE approvalsequence_standardleave (
        id int(11) NOT NULL AUTO_INCREMENT,
        department_id int(11) NOT NULL,
        position_id int(11) NOT NULL,
        approver_id int(11) NOT NULL,
        sequence_no int(11) NOT NULL,
        active int(11) NOT NULL,
        created_by varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


       CREATE TABLE approvalsequence_standard_history (
        id int(11) NOT NULL AUTO_INCREMENT,
        position_id int(11) NOT NULL,
        previous_approver int(11) NOT NULL,
        new_approver int(11) NOT NULL,
        sequence_no int(11) NOT NULL,
        active int(11) NOT NULL DEFAULT 1,
        notes varchar(1000) COLLATE utf8_unicode_ci DEFAULT '',
        createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id,position_id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


       CREATE TABLE standardleave_history (
        id int(11) NOT NULL AUTO_INCREMENT,
        standardleave_id int(11) NOT NULL,
        requestNo varchar(20) COLLATE utf8_unicode_ci NOT NULL,
        staff_id int(11) NOT NULL,
        status varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
        notes varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
        ipAddress varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id,standardleave_id,requestNo,staff_id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


       CREATE TABLE access_pages (
        id int(11) NOT NULL AUTO_INCREMENT,
        user_type int(11) NOT NULL,
        module_id int(11) NOT NULL,
        sub_module_id int(11) NOT NULL,
        description varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
        page_name varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
        active int(11) NOT NULL,
        created_by varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


       CREATE TABLE access_modules_sub (
        id int(11) NOT NULL AUTO_INCREMENT,
        module_id int(11) NOT NULL,
        sub_module_name varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
        description varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
        active int(11) NOT NULL,
        created_by varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

       CREATE TABLE access_menu_left_sub (
        id int(11) NOT NULL AUTO_INCREMENT,
        menu_left_id int(11) NOT NULL,
        menu_name_sub varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
        page_name varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
        active int(11) NOT NULL,
        created_by varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

       CREATE TABLE access_menu_matrix (
        id int(11) NOT NULL AUTO_INCREMENT,
        user_type_id int(11) NOT NULL,
        module_id int(11) NOT NULL,
        active int(11) NOT NULL,
        created_by varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

       CREATE TABLE access_sub_menu_matrix (
        id int(11) NOT NULL AUTO_INCREMENT,
        user_type_id int(11) NOT NULL,
        access_menu_left_sub_id int(11) NOT NULL,
        active int(11) NOT NULL,
        created_by varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


       CREATE TABLE internalleaveovertime (
        id int(11) NOT NULL AUTO_INCREMENT,
        requestNo varchar(15) COLLATE utf8_unicode_ci DEFAULT '',
        dateFiled datetime DEFAULT current_timestamp(),
        notes varchar(500) COLLATE utf8_unicode_ci DEFAULT '',
        attachment varchar(500) COLLATE utf8_unicode_ci DEFAULT '',
        isFinalized varchar(1) COLLATE utf8_unicode_ci DEFAULT 'N',
        createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

       CREATE TABLE internalleaveovertimedetails_draft (
        id int(11) NOT NULL AUTO_INCREMENT,
        internalleaveovertime_id varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
        leavetype_id int(11) NOT NULL,
        staffId varchar(11) COLLATE utf8_unicode_ci NOT NULL,
        startDate date DEFAULT NULL,
        endDate date DEFAULT NULL,
        total smallint(6) DEFAULT 0,
        status varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
        notes varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
        addType smallint(6) DEFAULT 1,
        createdBy varchar(11) COLLATE utf8_unicode_ci DEFAULT '',
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id,internalleaveovertime_id,leavetype_id,staffId),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

       CREATE TABLE internalovertime_finalapprover (
        id int(11) NOT NULL AUTO_INCREMENT,
        position_id int(11) NOT NULL,
        active int(11) NOT NULL,
        createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


       CREATE TABLE internalleaveovertime_approvalsequence (
        id int(11) NOT NULL AUTO_INCREMENT,
        department_id int(11) NOT NULL,
        position_id int(11) NOT NULL,
        approver_id int(11) NOT NULL,
        sequence_no int(11) NOT NULL,
        is_final int(11) NOT NULL DEFAULT 0,
        active int(11) NOT NULL,
        created_by varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


       CREATE TABLE internalleaveovertime (
        id int(11) NOT NULL AUTO_INCREMENT,
        requestNo varchar(20) COLLATE utf8_unicode_ci NOT NULL,
        staff_id varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
        currentStatus varchar(50) COLLATE utf8_unicode_ci NOT NULL,
        current_sequence_no smallint(6) DEFAULT 0,
        current_approver_id smallint(6) DEFAULT 0,
        position_id smallint(6) DEFAULT 0,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id,staff_id),
        UNIQUE KEY id_UNIQUE (id),
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


       CREATE TABLE internalleaveovertime_history (
        id int(11) NOT NULL AUTO_INCREMENT,
        internalleaveovertime_id int(11) NOT NULL,
        requestNo varchar(20) COLLATE utf8_unicode_ci NOT NULL,
        staff_id int(11) NOT NULL,
        status varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
        notes varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
        ipAddress varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
        created datetime DEFAULT current_timestamp(),
        modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id,internalleaveovertime_id,requestNo,staff_id),
        UNIQUE KEY id_UNIQUE (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


        SELECT ot.*, d.name as department, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sp.name as sponsor, r.notes FROM internalleaveovertime as ot 
        LEFT OUTER JOIN employmentdetail as e ON e.staff_id = ot.staff_id
        LEFT OUTER JOIN staff as s ON s.staffId = ot.staff_id
        LEFT OUTER JOIN department as d ON d.id = e.department_id
        LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
        LEFT OUTER JOIN internalleaveovertimefiled as r ON r.requestNo = ot.requestNo
        WHERE ot.current_approver_id = 6 AND ot.currentStatus = 'Pending' AND e.isCurrent = 1
        ORDER BY ot.id


        id, requestNo, shl, stl, otl, clr, staffIdFrom, staffIdTo, startDate, endDate, status, reason, created_by, created, modified    
        CREATE TABLE delegation (
            id int(11) NOT NULL AUTO_INCREMENT,
            requestNo varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
            shl smallint(6) DEFAULT 0,
            stl smallint(6) DEFAULT 0,
            otl smallint(6) DEFAULT 0,
            clr smallint(6) DEFAULT 0,
            staffIdFrom varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
            staffIdTo varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
            startDate date DEFAULT NULL,
            endDate date DEFAULT NULL,
            status varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
            reason varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
            createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
            created datetime DEFAULT current_timestamp(),
            modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id,requestNo),
            UNIQUE KEY id_UNIQUE (id)
           ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


           CREATE TABLE delegation_history (
            id int(11) NOT NULL AUTO_INCREMENT,
            delegation_id int(11) NOT NULL,
            requestNo varchar(20) COLLATE utf8_unicode_ci NOT NULL,
            staff_id int(11) NOT NULL,
            status varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            notes varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
            ipAddress varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
            created datetime DEFAULT current_timestamp(),
            modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id,delegation_id,requestNo,staff_id),
            UNIQUE KEY id_UNIQUE (id)
           ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

           CREATE TABLE delegation_pages (
            id int(11) NOT NULL AUTO_INCREMENT,
            page_name varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            display_name varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            active smallint(6) DEFAULT 0,
            createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
            created datetime DEFAULT current_timestamp(),
            modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id,page_name),
            UNIQUE KEY id_UNIQUE (id)
           ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

           SELECT fpuserlog.userid AS StaffId,fpuserlog.recordDate AS Date,cast(fpuserlog.inTime as time) AS TimeIn,cast(fpuserlog.outTime as time) AS TimeOut,case when (cast(fpuserlog.outTime as time) = '00:00:00' or cast(fpuserlog.inTime as time) = '00:00:00') then '00:00:00' else sec_to_time(time_to_sec(timediff(fpuserlog.outTime,fpuserlog.inTime))) end AS noOfHours,timestampdiff(MINUTE,fpuserlog.inTime,fpuserlog.outTime) / 60 AS decimalNoOfHours,case when timestampdiff(MINUTE,fpuserlog.inTime,fpuserlog.outTime) / 60 > 7.0 then sec_to_time(timestampdiff(SECOND,fpuserlog.inTime,fpuserlog.outTime) - 25200) else 'N/A' end AS overTime,case when timestampdiff(MINUTE,fpuserlog.inTime,fpuserlog.outTime) / 60 < 7.0 then 'Y' else 'N' end AS underTime,case when (fpuserlog.inEvent = '' or fpuserlog.outEvent = '') then 'Y' else 'N' end AS missingTime from fpuserlog where fpuserlog.recordDate >= '2016-07-17' order by fpuserlog.recordDate DESC


           CREATE TABLE holiday (
            id int(11) NOT NULL AUTO_INCREMENT,
            name varchar(500) COLLATE utf8_unicode_ci NOT NULL,
            arabicName varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            startDate date DEFAULT NULL,
            endDate date DEFAULT NULL,
            total smallint(6) DEFAULT 0,
            isRamadan smallint(6) DEFAULT 0,
            createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
            created datetime DEFAULT current_timestamp(),
            modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            UNIQUE KEY id_UNIQUE (id)
           ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


            TRUNCATE TABLE dbhr3_test.holiday;
            INSERT INTO dbhr3_test.holiday (name, arabicName, startDate, endDate, total, isRamadan, createdBy)
            SELECT name, arabicName, startDate, noOfDays, isRamadan, enteredBy FROM dbhr.holiday;

            CREATE TABLE delegation_pages_access (
                id int(11) NOT NULL AUTO_INCREMENT,
                delegation_id smallint(6) DEFAULT 0,
                access_menu_left_sub_id varchar(50) COLLATE utf8_unicode_ci NOT NULL,
                active smallint(6) DEFAULT 0,
                createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
                created datetime DEFAULT current_timestamp(),
                modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (id),
                UNIQUE KEY id_UNIQUE (id)
               ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

            CREATE TABLE e_forms_request (
                id int(11) NOT NULL AUTO_INCREMENT,
                requestBy int(11) DEFAULT 0,
                eFormId smallint(6) DEFAULT 0,
                status varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
                reason varchar(1024) COLLATE utf8_unicode_ci DEFAULT '',
                updatedBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
                createdBy varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
                created datetime DEFAULT current_timestamp(),
                modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (id),
                UNIQUE KEY id_UNIQUE (id)
               ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

               CREATE TABLE eforms (
                id int(11) NOT NULL AUTO_INCREMENT,
                name varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
                active tinyint(4) NOT NULL DEFAULT 1,
                created datetime DEFAULT current_timestamp(),
                modified datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (id),
                UNIQUE KEY id_UNIQUE (id,name)
               ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci









-------------------------------------------------------MSSQL-------------------------------------------------------

CREATE VIEW v_attendance as
SELECT fpuserlog.userid AS StaffId,fpuserlog.recordDate AS Date,
cast(fpuserlog.inTime as time) AS TimeIn,
cast(fpuserlog.outTime as time) AS TimeOut,
case when (cast(fpuserlog.outTime as time) = '00:00:00' or cast(fpuserlog.inTime as time) = '00:00:00') then '00:00:00' 
else 

CONVERT(varchar(6),DATEDIFF(SECOND,fpuserlog.inTime,fpuserlog.outTime)/3600) + ':'
+ RIGHT('0' + CONVERT(varchar(2), (DATEDIFF(second, fpuserlog.inTime,fpuserlog.outTime) % 3600) / 60), 2)
+ ':'
+ RIGHT('0' + CONVERT(varchar(2), DATEDIFF(second, fpuserlog.inTime,fpuserlog.outTime) % 60), 2) 
end AS noOfHours,

DATEDIFF(MINUTE,fpuserlog.inTime,fpuserlog.outTime) / 60.00 AS decimalNoOfHours,
case when DATEDIFF(MINUTE,fpuserlog.inTime,fpuserlog.outTime) / 60.00 > 7.00 then 

CONVERT(varchar(6), DATEDIFF(SECOND,fpuserlog.inTime,fpuserlog.outTime)/3600 - 7) + ':'
+ RIGHT('0' + CONVERT(varchar(2), (DATEDIFF(second, fpuserlog.inTime,fpuserlog.outTime) % 3600) / 60), 2)
+ ':'
+ RIGHT('0' + CONVERT(varchar(2), DATEDIFF(second, fpuserlog.inTime,fpuserlog.outTime) % 60), 2) 
else 'N/A' end AS overTime,

case when DATEDIFF(MINUTE,fpuserlog.inTime,fpuserlog.outTime) / 60.00 < 7.00 then 'Y' else 'N' end AS underTime,
case when (fpuserlog.inEvent = '' or fpuserlog.outEvent = '') then 'Y' else 'N' end AS missingTime 
from fpuserlog where fpuserlog.recordDate >= '2017-07-17'


CREATE VIEW v_standardleave as
SELECT s.id AS id,s.staff_id AS staff_id, sf.firstName AS staffName,
d.name AS department,sec.name AS section,sp.name AS sponsor,s.requestNo AS requestNo,l.name AS leave_type,
CONVERT(VARCHAR(12), s.dateFiled, 103) AS dateFiled,CONVERT(VARCHAR(12), s.startDate, 103) AS startDate,
CONVERT(VARCHAR(12), s.endDate, 103) AS endDate,s.total AS total,s.modified AS modified,s.currentStatus AS currentStatus 
FROM standardleave s 
left join staff sf on s.staff_id = sf.staffId 
left join leavetype l on s.leavetype_id = l.id 
left join employmentdetail e on e.staff_id = s.staff_id 
left join department d on d.id = e.department_id 
left join section sec on sec.id = e.section_id 
left join sponsor sp on sp.id = e.sponsor_id 
WHERE e.isCurrent = 1






?>