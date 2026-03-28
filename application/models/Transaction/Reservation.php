<?php

class Reservation extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function Reservation_Val()
	{
		 $this->form_validation->set_rules('mobile', 'mobile', 'required');
		 $this->form_validation->set_rules('Name', 'Name', 'required');
		 $this->form_validation->set_rules('City', 'City', 'required');
		 
		 if ($this->form_validation->run() == FALSE)
		 {
			 $output = $this->form_validation->return_f_error($this->input->post());
			 echo $output = json_encode($output);
		 }
		 else
		 {
			$output = $this->form_validation->return_success($this->input->post());
			echo $output = json_encode($output);
		 } 
	}
	function Reservation_exec()
	{ 	  
	  $date=date("Y-m-d");
	  $time= date("H:i:s");
	  $sql="select * from Mas_Customer where Mobile='".$_REQUEST['mobile']."'";
	  $res=$this->db->query($sql);
	  $numberofrow= $res->num_rows();
	  if($numberofrow ==0)
	  {
	   $qry= " Exec_RuningCustomer '".$_REQUEST['Name']."','','1','".$_REQUEST['mobile']."','".$_REQUEST['Email']."','1','1','1',''";
		$resq=$this->db->query($qry);
		$this->db->close();
		$this->db->reconnect();	
      }
	  
	  $sql1="select * from Mas_Customer where Mobile='".$_REQUEST['mobile']."'";
	  $res1=$this->db->query($sql1);
	  foreach ($res1->result_array() as $rows)
	  {
		$Customer_Id=$rows['Customer_Id']; 		 
	  }
	
	 for ($a = 0; $a < count($_REQUEST["ID"]); $a++)
	 {
		$Indate = str_replace('/', '-', $_REQUEST['Arrivaldate'][$a]);
	    $Indate=date('Y-m-d', strtotime($Indate));
	    $Indate1=date('m/d/Y', strtotime($Indate));
	    $todate = str_replace('/', '-', $_REQUEST['Departuredate'][$a]);
	    $todate=date('Y-m-d', strtotime($todate));
		
		$sql3="SELECT * FROM Mas_Room rm
		Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
		where rm.RoomNo='".$_REQUEST['RoomNo'][$a]."'";
	    $res3=$this->db->query($sql3);
	    foreach ($res3->result_array() as $row3)
	    {
		 $Room_id=$row3['Room_Id'];
		 $RoomType_Id=$row3['RoomType_Id'];
		 $Adults=$row3['Adults'];
		 $Extrabedamount=$row3['Extrabedamount'];
	    }
		$ins="Insert into Trans_reserve_mas(ResNo,Reserveby,Communicate,Resdate,cusid,totamt,totrooms,stat,userid,waitlist,duedate,travelagentid,onlinebookingno,totalrent,age,discper,discount,muserid,Roomid)
	       values(dbo.ResNo(),'".User_id."','P','".$date."','".$Customer_Id."','".$_REQUEST['Tariff'][$a]."','1','','".User_id."','0','".$date."','".$_REQUEST['TravelAgent']."','".$_REQUEST['bookingid']."','".$_REQUEST['Tariff'][$a]."','','".$_REQUEST['TariffDiscountper']."','".$_REQUEST['TariffDiscountamt']."','".User_id."','".$Room_id."')";
		$Discamt=0;
		$sql5="select dbo.Get_Taxid('".$_REQUEST['Tariff'][$a]."','".$_REQUEST['Tariff'][$a]."','".$_REQUEST['Tariff'][$a]."','".$Extrabedamount."','".$Discamt."','".$Indate1."') as Taxid";
		$res5=$this->db->query($sql5);   $ins1='';
		foreach ($res5->result_array() as $row5)
		{ $Taxid=$row5['Taxid'];}
		$ins1=$ins1."Insert into Trans_reserve_det(fromdate,noofrooms,noofpax,resid,fromtime,totime,todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,roomrent,totalroomrent,taxid,actpax)
			values('".$Indate."','1','".$_REQUEST['Adult'][$a]."',@Siden,convert(VARCHAR,getdate(),108),convert(VARCHAR,getdate(),108),'".$todate."','0','0','".$_REQUEST['Roomtype'][$a]."','".$_REQUEST['Roomtype'][$a]."','".$_REQUEST['Ratetype'][$a]."','".$_REQUEST['foodplan'][$a]."','0','0.00','".$_REQUEST['Tariff'][$a]."','".$_REQUEST['Tariff'][$a]."','".$Taxid."','".$_REQUEST['Adult'][$a]."')";
	    $fromdate=$Indate; $ins3='';
	
	    while($todate >= $Indate) 
		{		
	     $ins3=$ins3."Insert into Trans_reserve_det1(resdate,typeid,noofrooms,fromtime,totime,refresdetid,fromdate,todate,ratetypeid)
		 values('".$Indate."','".$_REQUEST['Roomtype'][$a]."','1',convert(VARCHAR,getdate(),108),convert(VARCHAR,getdate(),108),@Siden1,'".$fromdate."','".$todate."','".$_REQUEST['Ratetype'][$a]."')";
         $Indate = date ("Y-m-d", strtotime("+1 day", strtotime($Indate)));
		} 
		$sel="SELECT 'Successfully Updated' AS MGS";
		ob_start();
		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo "Declare @Siden1 INT; ";
		echo $ins;				
		echo "set @Siden=@@identity; ";
	    echo $ins1;
		echo "set @Siden1=@@identity; ";
		echo $ins3;
		echo $sel;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$ran=rand().rand().rand(); 
		$sq = "Create Procedure #".$ran." as ".$sqc.""; 
		$result = $this->db->query($sq);
		//$result = $this->db->query("exec #".$ran);
		$qry="exec #".$ran;
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry); 
     }
		
		
	
	}
}
?>
