DELIMITER $$
CREATE DEFINER=`newvracco`@`localhost` PROCEDURE `sp_bank_list`(IN `pay_group` VARCHAR(255), IN `period_year` VARCHAR(11), IN `period_month` VARCHAR(11), IN `pay_type` VARCHAR(255))
    NO SQL
BEGIN
SET SESSION group_concat_max_len=4294967295;
SET sql_mode = '';

SET @year='';
SET @month='';
SET @payGroup='';
SET @DFLT_PAY_TYPE='SAL';
SET @DFLT_REC_ACC='00040-06948300-35';
SET @NET_CODE='N';


IF (period_year  IS NOT NULL AND period_year != '') THEN
SET @year=period_year;
END IF;

IF (period_month IS NOT NULL AND period_month != '') THEN
SET @month=period_month;
END IF;

IF (pay_group IS NOT NULL AND pay_group != '') THEN
SET @payGroup=pay_group;
END IF;

IF (pay_type IS NOT NULL AND pay_type != '') THEN
SET @DFLT_PAY_TYPE=pay_type;
END IF;


SET @prlIds =CONCAT("SELECT  id FROM payrolls where pay_period_year=",@year," and pay_period_month=",@month," and FIND_IN_SET(pay_group,",QUOTE(@payGroup),")");

 
SET @net_sal = CONCAT ('SUM(IF(itm.code = '
            ,QUOTE(@NET_CODE)
            ,',v.amount,0)) AS '
                  ,QUOTE('crAmount')
            );
          
            
      
SET @sql = CONCAT('SELECT e.id as employee_id,e.employee_no,CONCAT(e.first_name," ",e.last_name) AS name,',@net_sal,',(',QUOTE(@DFLT_PAY_TYPE) ,') as pay_type,(',QUOTE(@DFLT_REC_ACC) ,') as rec_acc FROM payrolls prl  
                  INNER JOIN payslips ps on prl.id=ps.pay_period
                  INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                  INNER JOIN employees e on ps.employee=e.id 
                   
               
                   ');




IF (@prlIds IS NOT NULL ) THEN                 
SET @sql = CONCAT(@sql,"  where prl.id in (",@prlIds,") and itm.code=",QUOTE(@NET_CODE)," and v.amount !=0");
SET @sql=CONCAT(@sql," GROUP BY v.pay_slip");
SET @sql=CONCAT(@sql," ORDER BY crAmount DESC");



END IF;

    PREPARE stmt FROM  @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`newvracco`@`localhost` PROCEDURE `sp_cbhi`(IN `pay_group` VARCHAR(255), IN `period_year` VARCHAR(11), IN `period_month` VARCHAR(11))
    NO SQL
BEGIN
SET SESSION group_concat_max_len=4294967295;
SET sql_mode = '';
SET @statutory="CBHI";
SET @year=null;
SET @month=null;
SET @payGroup=null;


SET @prlIds ="SELECT  id FROM payrolls";

IF (period_year  IS NOT NULL AND period_year != '') THEN
SET @year=period_year;
SET @prlIds =CONCAT(@prlIds," where pay_period_year=",@year);

END IF;

IF (period_month IS NOT NULL AND period_month != '') THEN
SET @month=period_month;
SET @prlIds =CONCAT(@prlIds," and pay_period_month=",@month);
END IF;

IF (pay_group IS NOT NULL AND pay_group != '') AND (pay_group != 'ALL') THEN
SET @payGroup=pay_group;
SET @prlIds= CONCAT(@prlIds,"  and FIND_IN_SET(pay_group,",QUOTE(@payGroup),")");
END IF;

SET @cbhi = CONCAT ('SUM(IF(itm.statutory_type = '
            ,QUOTE(@statutory)
            ,',v.amount,0)) AS '
                  ,QUOTE('cbhi')
            );
SET @cbhi_basis = CONCAT ('SUM(IF(itm.cbhi_payable = '
            ,1
            ,',v.amount,0)) AS cbhi_basis'
           
            );            
            
      
SET @sql = CONCAT('SELECT e.employee_no as emp_no, CONCAT(e.first_name," ",e.last_name) AS names,',@cbhi_basis,',', @cbhi,' FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                  INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                   ');




IF (@prlIds IS NOT NULL ) THEN                 
SET @sql = CONCAT(@sql,'  where prl.id in (',@prlIds,')');
SET @sql=CONCAT(@sql,' GROUP BY v.pay_slip');
SET @sql=CONCAT(@sql,' ORDER BY e.first_name ASC');


END IF;

    PREPARE stmt FROM  @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`newvracco`@`localhost` PROCEDURE `sp_inkunga`(IN `pay_group` VARCHAR(255), IN `period_year` VARCHAR(11), IN `period_month` VARCHAR(11))
    NO SQL
BEGIN
SET SESSION group_concat_max_len=4294967295;
SET sql_mode = '';
SET @ded="INKU";
SET @year=null;
SET @month=null;
SET @payGroup=null;


SET @prlIds ="SELECT  id FROM payrolls";

IF (period_year  IS NOT NULL AND period_year != '') THEN
SET @year=period_year;
SET @prlIds =CONCAT(@prlIds," where pay_period_year=",@year);

END IF;

IF (period_month IS NOT NULL AND period_month != '') THEN
SET @month=period_month;
SET @prlIds =CONCAT(@prlIds," and pay_period_month=",@month);
END IF;

IF (pay_group IS NOT NULL AND pay_group != '') AND (pay_group != 'ALL') THEN
SET @payGroup=pay_group;
SET @prlIds= CONCAT(@prlIds,"  and FIND_IN_SET(pay_group,",QUOTE(@payGroup),")");
END IF;

SET @inkunga = CONCAT ('SUM(IF(itm.code = '
            ,QUOTE(@ded)
            ,',v.amount,0)) AS '
                  ,QUOTE('inkunga')
            );
SET @inkunga_basis = CONCAT ('SUM(IF(itm.inkunga_payable = '
            ,1
            ,',v.amount,0)) AS inkunga_basis'
           
            );            
            
      
SET @sql = CONCAT('SELECT e.employee_no as emp_no,CONCAT(e.first_name," ",e.last_name) AS name,',@inkunga_basis,',', @inkunga,' FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                  INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                   ');




IF (@prlIds IS NOT NULL ) THEN                 
SET @sql = CONCAT(@sql,'  where prl.id in (',@prlIds,')');
SET @sql=CONCAT(@sql,' GROUP BY v.pay_slip');
SET @sql=CONCAT(@sql,' ORDER BY e.first_name ASC');


END IF;

    PREPARE stmt FROM  @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`newvracco`@`localhost` PROCEDURE `sp_matleave`(IN `pay_group` VARCHAR(255), IN `period_year` VARCHAR(11), IN `period_month` VARCHAR(11))
    NO SQL
BEGIN
SET SESSION group_concat_max_len=4294967295;
SET sql_mode = '';
SET @statutory='RSSBML';
SET @year=null;
SET @month=null;
SET @payGroup=null;
SET @typeDeclared='B';

IF (period_year  IS NOT NULL AND period_year != '') THEN
SET @year=period_year;
END IF;

IF (period_month IS NOT NULL AND period_month != '') THEN
SET @month=period_month;
END IF;

IF (pay_group IS NOT NULL AND pay_group != '') THEN
SET @payGroup=pay_group;
END IF;


SET @prlIds =CONCAT("SELECT  id FROM payrolls where pay_period_year=",@year," and pay_period_month=",@month," and FIND_IN_SET(pay_group,",QUOTE(@payGroup),")");

 
SET @ctb = (
    select 
        GROUP_CONCAT( DISTINCT
            CONCAT ('SUM(IF(v.item = '
            ,item
            ,',v.amount,0)) AS '
            , char(39),code,char(39)
            )
        )
         from payItems itm  inner join  payslip_items v on v.item=itm.id  inner join payslips ps  on v.pay_slip=ps.id left join payrolls prl on prl.id=ps.pay_period where  itm.statutory_type=@statutory 
    );
    
SET @pension_basis= CONCAT ('SUM(IF(itm.pensionable = '
            ,1
            ,',v.amount,0)) AS pension_basis'
           
            );

                       
  SET @tot= CONCAT ('SUM(IF(itm.statutory_type = '
            ,QUOTE(@statutory )
            ,',v.amount,0)) AS total'
           
            ); 
            
SET @sql = CONCAT('SELECT  c.comp_pension_no , prl.pay_period_start as declared_period, (',QUOTE(@typeDeclared) ,') as type_delcared,s.emp_pension_no as rssb_emp_no ,e.employee_no as emp_no, e.first_name ,e.last_name,e.nic_num as nid,e.birthday as dob,',@pension_basis,',',  @ctb, ',',@tot,',prl.pay_period_start as starting_date ,prl.pay_period_end as ending_date FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                  INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                  LEFT JOIN emp_statutory_details s ON s.employee = e.id 
                  CROSS JOIN comp_statutory_details c ');

IF (@prlIds IS NOT NULL ) THEN                 
SET @sql = CONCAT(@sql,'  where prl.id in (',@prlIds,')');
SET @sql=CONCAT(@sql,' GROUP BY ps.id ');
SET @sql=CONCAT(@sql,' ORDER BY e.first_name ASC');
END IF;

    PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`newvracco`@`localhost` PROCEDURE `sp_mmi`(IN `pay_group` VARCHAR(11), IN `period_year` VARCHAR(11), IN `period_month` VARCHAR(11))
BEGIN
SET SESSION group_concat_max_len=4294967295;
SET sql_mode = '';
SET @statutory="MMI";
SET @year=null;
SET @month=null;
SET @payGroup=null;
SET @cond='';


IF (period_year  IS NOT NULL AND period_year != '') THEN
SET @year=period_year;
SET  @cond =CONCAT( @cond," where pay_period_year=",@year);

END IF;

IF (period_month IS NOT NULL AND period_month != '') THEN
SET @month=period_month;
SET @cond =CONCAT(@cond," and pay_period_month=",@month);
END IF;

IF (pay_group IS NOT NULL AND pay_group != '')  THEN
SET @payGroup=pay_group;
SET @cond= CONCAT(@cond," and FIND_IN_SET(pay_group,",QUOTE(@payGroup),")");
END IF;

SET @prlIds =CONCAT("SELECT  id FROM payrolls ",@cond);

SET @mmi_ctb = (
    select 
        GROUP_CONCAT( DISTINCT
            CONCAT ('SUM(IF(v.item = '
            ,item
            ,',v.amount,0)) AS '
            , char(39),LOWER(code),char(39)
            )
        )
         from payItems itm  inner join  payslip_items v on v.item=itm.id  inner join payslips ps  on v.pay_slip=ps.id left join payrolls prl on prl.id=ps.pay_period where  itm.statutory_type=@statutory 
    );


SET @mmi_basis = CONCAT ('SUM(IF(itm.mmi_payable = '
            ,1
            ,',v.amount,0)) AS mmi_basis'
           
            );
            
SET @mmi_tot = CONCAT ('SUM(IF(itm.statutory_type = '
            ,QUOTE(@statutory)
            ,',v.amount,0)) AS total'
           
            );
            
         
           
SET @sql = CONCAT('SELECT e.employee_no as emp_no,CONCAT(e.first_name," ",e.last_name) AS name,CONCAT(
        "[", 
           GROUP_CONCAT(
          IF(itm.mmi_payable,JSON_OBJECT(
                itm.code,v.amount
                
            ),null)
        ),"]") AS mmi_payable,',@mmi_basis,',',@mmi_ctb,',',@mmi_tot,' FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                  INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                   ');


IF (@prlIds IS NOT NULL ) THEN                 
SET @sql = CONCAT(@sql,'  where prl.id in (',@prlIds,')');
SET @sql=CONCAT(@sql,' GROUP BY v.pay_slip');
SET @sql=CONCAT(@sql,' ORDER BY e.first_name ASC');


END IF;

    PREPARE stmt FROM  @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`newvracco`@`localhost` PROCEDURE `sp_paye`(IN `pay_group` VARCHAR(255), IN `period_year` VARCHAR(11), IN `period_month` VARCHAR(11), IN `paye_basis` VARCHAR(11))
BEGIN
SET SESSION group_concat_max_len=4294967295;
SET sql_mode = '';
SET @statutory="PAYE";
SET @payeBasis="SAL";
SET @year=null;
SET @month=null;
SET @payGroup=null;


SET @prlIds ="SELECT  id FROM payrolls";

IF (period_year  IS NOT NULL AND period_year != '') THEN
SET @year=period_year;
SET @prlIds =CONCAT(@prlIds," where pay_period_year=",@year);

END IF;

IF (period_month IS NOT NULL AND period_month != '') THEN
SET @month=period_month;
SET @prlIds =CONCAT(@prlIds," and pay_period_month=",@month);
END IF;

IF (pay_group IS NOT NULL AND pay_group != '') AND (pay_group != 'ALL') THEN
SET @payGroup=pay_group;
SET @prlIds= CONCAT(@prlIds,"  and FIND_IN_SET(pay_group,",QUOTE(@payGroup),")");
END IF;

IF (paye_basis IS NOT NULL AND paye_basis != '') THEN
SET @payeBasis=paye_basis;
END IF;


SET @paye = CONCAT ('SUM(IF(itm.statutory_type = '
            ,QUOTE(@statutory)
            ,',v.amount,0)) AS '
                  ,QUOTE('PAYE')
            );
IF @payeBasis='SAL' THEN           
            
SET @gross = CONCAT ('SUM(IF(itm.subj_to_paye = '
            ,1
            ,',v.amount,0)) AS paye_basis'
           
            );

SET @sql = CONCAT('SELECT e.employee_no as emp_no, CONCAT(e.first_name," ",e.last_name) AS Name,CONCAT(
        "[", 
           GROUP_CONCAT(
          IF(itm.subj_to_paye,JSON_OBJECT(
                itm.code,v.amount
                
            ),null)
        ),"]") AS taxable  ,',@gross,',',@paye,' FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                  INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                   ');


ELSEIF  @payeBasis='ALLOW' THEN 

SET @sql = CONCAT('SELECT e.employee_no as emp_no,CONCAT(e.first_name," ",e.last_name) AS Name, ps.base_pay AS paye_basis,',@paye,' FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                 INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                   ');
                   
ELSEIF  @payeBasis='SUP' THEN 
SET @gross = CONCAT ('SUM(IF(itm.code = '
            ,QUOTE('G')
            ,',v.amount,0)) AS paye_basis'
           
            );
SET @sql = CONCAT('SELECT e.employee_no as emp_no,CONCAT(e.first_name," ",e.last_name) AS Name,',@gross,',',@paye,' FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                 INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                   ');                  
                   

END IF;

IF (@prlIds IS NOT NULL ) THEN                 
SET @sql = CONCAT(@sql,'  where prl.id in (',@prlIds,')');
SET @sql=CONCAT(@sql,' GROUP BY v.pay_slip');
SET @sql=CONCAT(@sql,' ORDER BY e.first_name ASC');


END IF;

    PREPARE stmt FROM  @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`newvracco`@`localhost` PROCEDURE `sp_pension`(IN `pay_group` VARCHAR(255), IN `period_year` VARCHAR(11), IN `period_month` VARCHAR(11))
BEGIN
SET SESSION group_concat_max_len=4294967295;
SET sql_mode = '';
SET @statutory='RSSBP';
SET @year=0;
SET @month=0;
SET @payGroup='';
SET @typeDeclared='B';

IF (period_year  IS NOT NULL AND period_year != '') THEN
SET @year=period_year;
END IF;

IF (period_month IS NOT NULL AND period_month != '') THEN
SET @month=period_month;
END IF;

IF (pay_group IS NOT NULL AND pay_group != '') THEN
SET @payGroup=pay_group;
END IF;


SET @prlIds =CONCAT("SELECT  id FROM payrolls where pay_period_year=",@year," and pay_period_month=",@month," and FIND_IN_SET(pay_group,",QUOTE(@payGroup),")");

 
SET @ctb = (
    select 
        GROUP_CONCAT( DISTINCT
            CONCAT ('SUM(IF(v.item = '
            ,item
            ,',v.amount,0)) AS '
            , char(39),code,char(39)
            )
        )
         from payItems itm  inner join  payslip_items v on v.item=itm.id  inner join payslips ps  on v.pay_slip=ps.id left join payrolls prl on prl.id=ps.pay_period where  itm.statutory_type=@statutory 
    );
    
SET @pension_basis= CONCAT ('SUM(IF(itm.pensionable = '
            ,1
            ,',v.amount,0)) AS pension_basis'
           
            );

                       
  SET @tot= CONCAT ('SUM(IF(itm.statutory_type = '
            ,QUOTE(@statutory )
            ,',v.amount,0)) AS total'
           
            ); 
            
SET @sql = CONCAT('SELECT  c.comp_pension_no , prl.pay_period_start as declared_period, (',QUOTE(@typeDeclared) ,') as type_delcared,s.emp_pension_no as rssb_emp_no ,e.employee_no as emp_no, e.first_name ,e.last_name,e.nic_num as nid,e.birthday as dob,',@pension_basis,',',  @ctb, ',',@tot,',prl.pay_period_start as starting_date ,prl.pay_period_end as ending_date FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                  INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                  LEFT JOIN emp_statutory_details s ON s.employee = e.id 
                  CROSS JOIN comp_statutory_details c ');

IF (@prlIds IS NOT NULL ) THEN                 
SET @sql = CONCAT(@sql,'  where prl.id in (',@prlIds,')');
SET @sql=CONCAT(@sql,' GROUP BY ps.id ');
SET @sql=CONCAT(@sql,' ORDER BY e.first_name ASC');
END IF;

    PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`newvracco`@`localhost` PROCEDURE `sp_rama`(IN `pay_group` VARCHAR(255), IN `period_year` VARCHAR(11), IN `period_month` VARCHAR(11))
BEGIN
SET SESSION group_concat_max_len=4294967295;
SET sql_mode = '';
SET @statutory='RSSBMI';
SET @year=0;
SET @month=0;
SET @payGroup='';
SET @typeDeclared='B';

IF (period_year  IS NOT NULL AND period_year != '') THEN
SET @year=period_year;
END IF;

IF (period_month IS NOT NULL AND period_month != '') THEN
SET @month=period_month;
END IF;

IF (pay_group IS NOT NULL AND pay_group != '') THEN
SET @payGroup=pay_group;
END IF;


SET @prlIds =CONCAT("SELECT  id FROM payrolls where pay_period_year=",@year," and pay_period_month=",@month," and FIND_IN_SET(pay_group,",QUOTE(@payGroup),")");

 
SET @ctb = (
    select 
        GROUP_CONCAT( DISTINCT
            CONCAT ('SUM(IF(v.item = '
            ,item
            ,',v.amount,0)) AS '
            , char(39),code,char(39)
            )
        )
         from payItems itm  inner join  payslip_items v on v.item=itm.id  inner join payslips ps  on v.pay_slip=ps.id inner join payrolls prl on prl.id=ps.pay_period where  itm.statutory_type=@statutory 
    );

SET @sql = CONCAT('SELECT  c.comp_rama_no , prl.pay_period_start as declared_period, (',QUOTE(@typeDeclared) ,') as type_delcared,s.emp_pension_no as rssb_emp_no ,s.emp_med_no as emp_rama_no ,e.employee_no as emp_no, e.first_name ,e.last_name, ps.base_pay,', @ctb,                       ',sum(v.amount) as total, prl.pay_period_start as starting_date ,prl.pay_period_end as ending_date FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                  INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                  LEFT JOIN emp_statutory_details s ON s.employee = e.id 
                  CROSS JOIN comp_statutory_details c ');

IF (@prlIds IS NOT NULL ) THEN                 
SET @sql = CONCAT(@sql,'  where prl.id in (',@prlIds,')');
SET @sql=CONCAT(@sql,' and itm.statutory_type=',QUOTE(@statutory),'  GROUP BY ps.id ');
SET @sql=CONCAT(@sql,' ORDER BY e.first_name ASC');
END IF;
    PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`newvracco`@`localhost` PROCEDURE `sp_sloan`(IN `pay_group` VARCHAR(255), IN `period_year` VARCHAR(11), IN `period_month` VARCHAR(11))
BEGIN
SET SESSION group_concat_max_len=4294967295;
SET sql_mode = '';
SET @ded="SLOAN";
SET @year=null;
SET @month=null;
SET @payGroup=null;


SET @prlIds ="SELECT  id FROM payrolls";

IF (period_year  IS NOT NULL AND period_year != '') THEN
SET @year=period_year;
SET @prlIds =CONCAT(@prlIds," where pay_period_year=",@year);

END IF;

IF (period_month IS NOT NULL AND period_month != '') THEN
SET @month=period_month;
SET @prlIds =CONCAT(@prlIds," and pay_period_month=",@month);
END IF;

IF (pay_group IS NOT NULL AND pay_group != '') AND (pay_group != 'ALL') THEN
SET @payGroup=pay_group;
SET @prlIds=CONCAT(@prlIds,"  and FIND_IN_SET(pay_group,",QUOTE(@payGroup),")");

END IF;

SET @sloan = CONCAT ('SUM(IF(itm.code = '
            ,QUOTE(@ded)
            ,',v.amount,0)) AS '
                  ,QUOTE('sloan')
            );
          
            
      
SET @sql = CONCAT('SELECT e.employee_no as emp_no,CONCAT(e.first_name," ",e.last_name) AS name,', @sloan,' FROM employees e 
                  INNER JOIN payslips ps on ps.employee=e.id 
                  INNER JOIN payrolls prl on prl.id=ps.pay_period
                  INNER JOIN payslip_items v ON ps.id = v.pay_slip
                  INNER JOIN payItems itm on v.item=itm.id
                   ');




IF (@prlIds IS NOT NULL ) THEN                 
SET @sql = CONCAT(@sql,"  where prl.id in (",@prlIds,") and itm.code=",QUOTE(@ded)," and v.amount !=0");
SET @sql=CONCAT(@sql," GROUP BY v.pay_slip");
SET @sql=CONCAT(@sql," ORDER BY e.first_name ASC");


END IF;

    PREPARE stmt FROM  @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
