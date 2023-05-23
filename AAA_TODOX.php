1. DONE! - Cancel filed short leave.
2. DONE! - No dismiss modal in the short leave approval once the approver has viewed it. Current solution is refresh the page which is not appropriate.
3. DONE! - settings_standard_leave_sequence.php - Fix the approval sequence settings here...
4. DONE! - Short leave maximum time is 4 hours.
5. DONE! - When emergency leave was selected, it goes to internalleavebalancedetails which is WRONG, it should go to emergencyleavebalancedetails
6. DONE! - For Approval of Standard Leave:
    1. No approval if the active field name in approvalsequence_standardleave is 0;
    2. If active field is 1, check the next sequence_no if active = 1, if active = 1 or 0, next sequence_no is the sequence_no of the next "ACTIVE = 1" approver. (NOTE: An alternative is that arrange the sequence_no in "Chronological" order)
    3. In relation to number 2, if no more next approval or no more next sequence_no that is ACTIVE = 1, mark the approval as "APPROVED". If your query reached 0 then that's it.
    4. If approved by DEAN, then it is automatically approved. Just inform the HR HoD.
7. DONE! - For every staff's qualification, attachment of documents should be required.
8. DONE! - Double check the delegation_create.php, there is an unfinished validation upon submit in there...Example: Selecting other staff name first then setting the date to a conflict date, and then go back to select the correct staff name this time the one with conflict...





9. (Short Leave) Validation like, leave date is equal to an existing standard leave date, the leave date, start and end time conflicts with the existing filed short leave.
11. In staff_qualification, change the dbhr3_test into the name of the live database once you put this system in production/live server.
12. In include_headers, change your connection parameters.
13. Under delegation, create a cron script that will check if the endDate for the delegation already reached, if YES then bring back the approval to the original ONE.
15. For emergency leave, considering that emergency leave has already reset by January 01, 2020, see example below:
    1. Date Filed: January 02, 2020
    2. Leave Date: From December 24, 2019 to December 25, 2019
    3. Leave balance MUST be deducted FROM THE PREVIOUS BALANCE of the YEAR 2019 NOT on the year 2020.
    4. If the staff has no enough balance from the year 2019, then deduct it on the year 2020 emergency balance.
16. DECLINE OVERTIME APPLICATION IS NOT CODED YET


standardleave_search.php - NOT COMPLETE
shortleave_search.php    - NOT COMPLETE
staff_search_basic.php   - NOT COMPLETE

