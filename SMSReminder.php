<?php

   $host        = "host=127.0.0.1";
   $port        = "port=5432";
   $dbname      = "dbname=dhis2";
   $credentials = "user=postgres password=__Postgr35__";

   $db = pg_connect( "$host $port $dbname $credentials" );

	if(!$db)
	{

	  echo "Error : Unable to open database\n";

	} else {

	  //echo "Opened database successfully\n";

	}


$sql =<<<EOF
SELECT DISTINCT ui.phonenumber  
FROM
  orgunitgroup og

INNER JOIN orgunitgroupmembers ogm
  ON ogm.orgunitgroupid = og.orgunitgroupid
FULL OUTER JOIN organisationunit ou
  ON ogm.organisationunitid = ou.organisationunitid
INNER JOIN organisationunit sc
  ON ou.parentid = sc.organisationunitid
INNER JOIN organisationunit di
  ON sc.parentid = di.organisationunitid

-- Comment Out If Necessary  

FULL OUTER JOIN usermembership um
  ON um.organisationunitid = ou.organisationunitid

FULL OUTER JOIN userinfo ui
  ON um.userinfoid = ui.userinfoid
FULL OUTER JOIN users u
  ON u.userid = ui.userinfoid

WHERE
  og.name LIKE '%PMTCT%'  
AND
  ui.phonenumber LIKE '2567%'
AND 
  length(ui.phonenumber) = 12
AND
  staging.cast_to_int8(ui.phonenumber, 0) > 0
AND
  ou.organisationunitid NOT IN
	(SELECT 
	  SourceID  

	FROM
	  DataValue dv
	INNER JOIN
	  Period ON Period.PeriodID = dv.PeriodID
	WHERE
	  Period.PeriodID IN (SELECT PeriodID FROM Period WHERE PeriodTypeID = 2 AND EndDate <= current_date - (extract(dow from current_date) || ' days')::interval ORDER BY enddate DESC LIMIT 1)
	AND
	  dv.DataElementID = 13252);
EOF;

   $ret = pg_query($db, $sql);
   if(!$ret)
   {
      echo pg_last_error($db);
      exit;
   }
  
   $recipients = "";

   while($row = pg_fetch_row($ret))
   {
	$recipients .= $row[0] . ",";
   }
    $recipients .= "256774558980,256752712007,256777829513";

   echo $recipients;

pg_close($db);
   
   
?>

