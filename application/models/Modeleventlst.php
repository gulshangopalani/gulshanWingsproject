<?php defined('BASEPATH') OR exit('No direct script access allowed');

		class Modeleventlst extends CI_Model
		{
			
			function __construct()
			{
		        $_POST = json_decode(file_get_contents('php://input'), true);
					 
			}
			function saveSport(){
				$chk=$this->chkSports($_POST['id']);
				if ($chk==0) {
					$insertData = array('id'=> $_POST['id'],'name'=> $_POST['name'],'marketCount'=> $_POST['marketCount']);
					$query=$this->db->insert('sportmst', $insertData);


					return true;
				}else{
					return false;
				}
				//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table
			}
      
			function saveMatchMarket(){
				//echo $_POST['MatchId'];
				$chk=$this->chkMatchMarket($_POST['marketId']);
				if ($chk==0) {
					$this->db->trans_start();
					if($_POST['SportsId'] == '7'){
						$insertData = array('Id'=> $_POST['marketId'],'Name'=> $_POST['marketName'],'matchId'=> $_POST['MatchId'],'sportsId'=> $_POST['SportsId'],'totalmatched'=> $_POST['totalMatched'],
						'createdOn'=>date('Y-m-d H:i:s',now()),'seriesId'=> '210','HelperID'=> $_POST['HelperID']);
					}
					else {
					$insertData = array('Id'=> $_POST['marketId'],'Name'=> $_POST['marketName'],'matchId'=> $_POST['MatchId'],'sportsId'=> $_POST['SportsId'],'totalmatched'=> $_POST['totalMatched'],
						'createdOn'=>date('Y-m-d H:i:s',now()),'seriesId'=> $_POST['seriesId'],'HelperID'=> $_POST['HelperID']);
					}
					//print_r($insertData);
					$MatchName=$this->getMatchNameById($_POST['MatchId']);

					//print_r($MatchName);
					$Name=$MatchName[0]->matchName;
					//die();
					$query=$this->db->insert('market', $insertData);

					
					$GetMarket= $_POST['marketName']."__".$Name;
					$menuoption1 = array('menCode'=> $_POST['marketId'],'menName'=> $GetMarket,'menDesc'=> $GetMarket,'mstType'=> '8');
					$query1=$this->db->insert('menuoption', $menuoption1);

					$this->db->trans_complete();

					//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table

					return true;
				}else{
								//sourabh 170105
					$GetpId=$this->Get_MarketActive( $_POST['marketId']);
					$Active=$GetpId[0]->active;
					if($Active==0)
						$dataArray = array('active' => 1,'HelperID'=> $_POST['HelperID']);
					else
						$dataArray = array('active' => 0,'HelperID'=> $_POST['HelperID']);

    				$this->db->where('Id', $_POST['marketId']);
					$this->db->update('market', $dataArray);
					/*echo $this->db->queries[0];die();	*/
				//sourabh 170105

				//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 1,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table

					return false;
				}
				
			}
			function getMatchNameById($matchId){
				$this->db->select("matchName");
				$this->db->from('matchmst');
				$this->db->where('MstCode',$matchId);
				$query = $this->db->get();
				return $query->result();

			}
      		function saveMatchMarketType(){
				//echo $_POST['MatchId'];
				$chk=$this->chkMatchMarketType($_POST['marketType'],$_POST['MatchId']);
				if ($chk==0) {
					$insertData = array('Name'=> $_POST['marketType'],'marketCount'=> $_POST['marketCount'],'matchId'=> $_POST['MatchId'],'sportsId'=> $_POST['SportsId'],'createdOn'=>date('Y-m-d H:i:s',now()));
					$query=$this->db->insert('markettype', $insertData);
					return true;
				}else{
					return false;
				}
				

				//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table
			}
			function chkMatchMarketType($Name,$matchId){

					$this->db->select('Id');
					$this->db->from('markettype');
					$this->db->where('Name', $Name);
	          		$this->db->where('matchId', $matchId);
						$query = $this->db->get();
						$num=$query->num_rows();
						
						if($num==1){

							return $num;
						}else{

							return $num;
						}
			}
      		function chkMatchMarket($id){

					$this->db->select('Id');
					$this->db->from('market');
					$this->db->where('Id', $id);
					$query = $this->db->get();
					$num=$query->num_rows();
					
					if($num==1){

						return $num;
					}else{

						return $num;
					}
			}
			function chkSports($id){

					$this->db->select('id');
					$this->db->from('sportmst');
					$this->db->where('id', $id);
					$query = $this->db->get();
					$num=$query->num_rows();
					
					if($num==1){
						return $num;
						//return false;
					}
					else{
						return $num;
						//return true;
					}
			}
			function saveSportMatch(){
				$chk=$this->chkSportsMatch($_POST['matchId']); 
				if ($chk==0) {
					$this->db->trans_start(); 
					if($_POST['sportId'] == 7){ 
						$insertData = array('seriesId'=> '210','MstCode'=> $_POST['matchId'],'matchName'=> $_POST['matchName'],'MstDate'=> $_POST['openDate'],'SportID'=> $_POST['sportId'],'countryCode'=> $_POST['countryCode'],'createdOn'=>date('Y-m-d H:i:s',now()),'HelperID'=> $_POST['HelperID']);
					}
					else{
						$insertData = array('seriesId'=>  $_POST['seriesId'],'MstCode'=> $_POST['matchId'],'matchName'=> $_POST['matchName'],'MstDate'=> $_POST['openDate'],'SportID'=> $_POST['sportId'],'countryCode'=> $_POST['countryCode'],'marketCount'=> $_POST['marketCount'],'createdOn'=>date('Y-m-d H:i:s',now()),'HelperID'=> $_POST['HelperID']);
					}
					
					$query=$this->db->insert('matchmst', $insertData);
					$menuoption1 = array('menCode'=> $_POST['matchId'],'menName'=> $_POST['matchName'],'menDesc'=> $_POST['matchName'],'mstType'=> '7');
					$query1=$this->db->insert('menuoption', $menuoption1); 
					$this->db->trans_complete();
					 
					
					//return true;
				}else{
				//sourabh 170105
					$GetpId=$this->Get_MatchActive( $_POST['matchId']);
					$Active=$GetpId[0]->active;
					if($Active==0)
						$dataArray = array('active' => 1,'HelperID'=> $_POST['HelperID'],'MstDate'=> $_POST['openDate']);
					else
						$dataArray = array('active' => 0,'HelperID'=> $_POST['HelperID'],'MstDate'=> $_POST['openDate']);

    				$this->db->where('MstCode', $_POST['matchId']);
					$this->db->update('matchmst', $dataArray);
					
					 
					if($Active==0)
					{
						return $Active = 0;
					}
					else
					{
						return $Active = 1;
					}
				}	
			}
			
			function chkSportsMatch($id){

					$this->db->select('MstCode');
					$this->db->from('matchmst');
					$this->db->where('MstCode', $id);
					$query = $this->db->get();
					$num=$query->num_rows();
					
					if($num==1){
						return $num;
						//return false;
					}
					else{
						return $num;
						//return true;
					}
			}
			function saveSportSeries()//sourabh 9-dec-2016
			{
				$chk=$this->chkSportsSeries($_POST['matchId']);
				
				if ($chk==0) {
					$this->db->trans_start();
					$insertData = array('seriesId'=> $_POST['matchId'],'Name'=> $_POST['matchName'],'mCount'=> $_POST['marketCount'],'region'=> $_POST['region'],'SportID'=> $_POST['sportId'],'HelperID'=> $_POST['HelperID']);
					$query=$this->db->insert('seriesmst', $insertData);

					$menuoption1 = array('menCode'=> $_POST['matchId'],'menName'=> $_POST['matchName'],'menDesc'=> $_POST['matchName'],'mstType'=> '6');
					$query1=$this->db->insert('menuoption', $menuoption1);
					$this->db->trans_complete();  
					
				}else{

					$GetpId=$this->Get_SeriesActive( $_POST['matchId']);
					$Active=$GetpId[0]->active;
					if($Active==0)
						$dataArray = array('active' => 1,'HelperID'=> $_POST['HelperID']); 
					else
						$dataArray = array('active' => 0,'HelperID'=> $_POST['HelperID']);
						
    				$this->db->where('seriesId', $_POST['matchId']);
				    $this->db->update('seriesmst', $dataArray);  
				if($Active==0)
					{
						return $Active = 0;
					}
					else
					{
						return $Active = 1;
					}
				
				}	
			}
			 function Get_SeriesActive($id){
				$this->db->select('active');
				$this->db->from('seriesmst');
				$this->db->where('seriesId', $id);
				$query = $this->db->get();
				return $query->result();
			}
			function chkSportsSeries($id)//sourabh 9-dec-2016
			{
					$this->db->select('seriesId');
					$this->db->from('seriesmst');
					$this->db->where('seriesId', $id);
					$query = $this->db->get();
					$num=$query->num_rows();
					if($num==1){
						return $num;
						//return false;
					}
					else{
						return $num;
						//return true;
					}
			}
			function getSportData(){
				$this->db->select('id,name');
				$this->db->from('sportmst');			
				$query = $this->db->get();
				return $query->result_array();
			}
			function getMatchLst($sportId,$seriesId){
				if($sportId==0){$condition="";$condition1="";$condition2="";}
				else{
					$condition=$this->db->where('SportID', $sportId);
					if($seriesId!=0)$condition2=$this->db->where('seriesId', $seriesId);
					$condition1=$this->db->where('active', 1);
				}
					$this->db->select("mtchMst.volumeLimit,mtchMst.oddsLimit,mtchMst.matchName,mtchMst.countryCode,mtchMst.marketCount,mtchMst.MstDate,spmst.name,mtchMst.active,mtchMst.SportID,mtchMst.MstCode");
			$this->db->from('matchmst mtchMst');
			$this->db->join('sportmst spmst', 'mtchMst.SportID=spmst.id', 'INNER');
			$condition;
			$condition1;
			$condition2;
			$this->db->order_by("matchName asc");
			$query = $this->db->get();
			/*echo $this->db->queries[0];die();	*/	

			return $query->result_array();
			}
			function getSeriesLst($matchId)//sourabh 9-dec-2016
			{
				if($matchId==0){$condition="";$condition1="";}
				else{
					$condition=$this->db->where('SportID', $matchId);
					$condition1=$this->db->where('active', 1);
				}
			
				$this->db->select("mtchMst.seriesId,mtchMst.Name,mtchMst.region,mtchMst.mCount,mtchMst.SportID,spmst.name as sportname,mtchMst.active");
				$this->db->from('seriesmst mtchMst');
				$this->db->join('sportmst spmst', 'mtchMst.SportID=spmst.id', 'INNER');
				$condition;
				$condition1;
				
				//$this->db->where('active', 1);
				$this->db->order_by("Name asc");
				$query = $this->db->get();
				
				return $query->result_array();
			}
			function getMarketLst(){ //Manish 20-03-2017				
				
				$this->db->select("seriesMst.Name,mtcmst.matchName,seriesMst.active,mrkt.Name as MarketName,mrkt.Id as MarketId,mrkt.gin_play_stake as stake");
				$this->db->from('seriesmst seriesMst');
				$this->db->join('matchmst mtcmst', 'mtcmst.seriesId=seriesMst.seriesId', 'INNER');
				$this->db->join('market mrkt', 'mrkt.matchId=mtcmst.MstCode', 'INNER');
				$this->db->where('seriesMst.active', 1);
				$this->db->order_by("Name asc");
				$query = $this->db->get();
				return $query->result_array();
			}
			function matchMarketTypeLst(){
				//print_r($_POST);die();

				$this->db->select("*");
				$this->db->from('markettype');
				$this->db->where('sportsId', $_POST['sportsId']);
				$this->db->where('matchId', $_POST['matchId']);
				$this->db->where('active', 1);
				
				$query = $this->db->get();
				/*echo $this->db->queries[0];die();		*/
				return $query->result_array();
			}
      		function matchMarketLst(){
				$sportId=$_POST['sportsId'];
				$matchId=$_POST['matchId'];
				$user_id=$_POST['user_id'];
				$query =$this->db->query("call GetMarket($sportId,$matchId,$user_id)");
				$res = $query->result_array();
				$query->next_result();
				$query->free_result();
				return $res;
			}
			function matchFancyList(){
				//$sportId=$_POST['sportsId'];
				$matchId=$_POST['matchId'];
				$user_id=$_POST['user_id'];				
				$query =$this->db->query("call getFancyList($matchId,$user_id)");
				$res = $query->result_array();
				$query->next_result();
				$query->free_result();
				return $res;				
			}
            function SessionFancyData(){
                $this->db->select("*,MFancyID as FncyId");
                $this->db->from('matchfancy');
                /*$this->db->where('sportsId', $_POST['sportsId']);*/
                $this->db->where('matchId', $_POST['matchId']);
                $this->db->where('TypeID',2);//sourabh 170107
                $this->db->where('active<>',2);
				$this->db->where('result',NULL);
                $query = $this->db->get();
                return $query->result_array();
            }
			function SaveSelection($selectionData,$matchId,$sportId,$MarketId){
				/*print_r($selectionData);
				die();*/
				$arr = json_decode($selectionData, true);
				/* $arrne['runnerName'] = "dsds";*/
				$index = 1;
				foreach ($arr as $key) {
					//echo $key['runnerName'];

					$file_data = array(	
								'sportId' => $sportId,
								'matchId' => $matchId,
								'marketId' => $MarketId,
								'selectionId' => $key['selectionId'],
								'selectionName' => $key['runnerName'],
								'teamType' => $index
							);
					$this->db->insert('tblSelection', $file_data);
					$index++;


					//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table
				}
				return true;
				

			}
			function GetSelectionFrmDatabase($marketId){
				$this->db->select("*");
				$this->db->from('tblSelection');
				$this->db->where('marketId', $marketId);
				$query = $this->db->get();
				return $query->result_array();
			}
			function SetResult(){
				$sportsId=$_POST['Sport_id'];
				$Match_id=$_POST['Match_id'];
				$market_id=$_POST['market_id'];
				$selectionId=$_POST['selectionId'];
				$result=1;
				$isFancy=$_POST['isFancy'];
				$sportName=$_POST['sportName'];
				$matchName=$_POST['matchName'];
				$MarketName=$_POST['MarketName'];
				$selectionName=$_POST['selectionName'];			
					
				$query = $this->db->query("call SP_SetResult($sportsId,$Match_id,$market_id,'$selectionId',$isFancy,$result,'$sportName','$matchName','$MarketName','$selectionName')");
				$res = $query->result_array();
				$query->next_result();
				$query->free_result();
				return $res;
				//print_r($res);
			}
			function GetMatchOddsResult(){
				 
				/*$this->db->select("mtchmst.matchName as MatchName,mrkt.Name as MarketName,sprt.name as sportName ,slectName.selectionName as SelectionName,tblres.date,tblres.result,tblres.resId,tblres.sportId,tblres.matchId,tblres.marketId");
				$this->db->from('tblresult tblres');
				$this->db->join('matchmst mtchmst', 'tblres.matchId=mtchmst.MstCode', 'INNER');
				$this->db->join('market mrkt', 'tblres.marketId=mrkt.id', 'INNER');
				$this->db->join('tblSelection slectName', 'tblres.selectionId=slectName.selectionId and tblres.marketId=slectName.marketId and slectName.matchId=tblres.matchId', 'INNER');
				$this->db->join('sportmst sprt', 'sprt.id= tblres.sportId', 'INNER');
				$this->db->where('tblres.result', 1);

				$query = $this->db->get();
				//echo $this->db->queries[0];
				return $query->result_array();*/
				$query = $this->db->query("call GetResult()");
				$res = $query->result_array();
				$query->next_result();
				$query->free_result();
				return $res;
			}
			function DeleteMatchResult($resId,$sportId,$matchId,$marketId,$selectionId,$isFancy){
                if($isFancy==1){
                    echo "call SP_DelResult($sportId,$matchId,$marketId,$selectionId,$resId,$selectionId)";
                    $query = $this->db->query("call SP_DelResult($sportId,$matchId,$marketId,$selectionId,$resId,$selectionId)");
                }
                else
                {
                   //echo "call SP_DelResult($sportId,$matchId,$marketId,$selectionId,$resId,0)";
                   $query = $this->db->query("call SP_DelResult($sportId,$matchId,$marketId,$selectionId,$resId,0)");
                }
                $res = $query->result_array();
                $query->next_result();
                $query->free_result();
                return $res;

			}
			function getUserMatchLst($sportId)//sourabh 14-dec-2016
			{
				//if($sportId==0){$condition="";$condition1="";}else  sourabh 170106
				if($sportId==-1){
					$this->db->select("mchmst.matchName,mf.HeadName,mf.TypeID,mf.MatchID as matchid,mf.ID as marketid,'' as MstDate,0 as oddsLimit,sm.name as sportname,mchmst.SportID as SportId");//sourabh 170106
					$this->db->from('matchfancy mf');
					$this->db->join('matchmst mchmst', 'mf.MatchID=mchmst.MstCode', 'INNER');
					$this->db->join('sportmst sm', 'mchmst.SportID=sm.id', 'INNER');//sourabh 170106
					$this->db->where('mchmst.active',1);
					//$this->db->where('mf.active',1);sourabh 170118
					$this->db->where('mf.active!=','2');//sourabh 170118
					$this->db->order_by("mf.ID desc");
					$query = $this->db->get();
					return $query->result_array();
				}
				else
				{
					if($sportId!=0)$condition=$this->db->where('mf.SportID', $sportId);//sourabh 170106
					else $condition="";//sourabh 170106
					$condition1=$this->db->where('mf.active', 1);
				
					$this->db->select("mf.matchName,'' HeadName,0 as TypeID,mf.MstCode as matchid,ma.Id as marketid,ma.Name as Market,mf.MstDate,oddsLimit,sm.name as sportname,sm.id as SportId");//sourabh 170106
					$this->db->from('matchmst mf');
					$this->db->join('market ma','ma.matchId=mf.MstCode', 'INNER');//sourabh new 161216
					$this->db->join('sportmst sm', 'mf.SportID=sm.id', 'INNER');//sourabh 170106
					$condition;
					$condition1;
					$this->db->where('ma.active', '1');
					//$this->db->where('ma.Name', 'Match Odds');//sourabh new 161216
					$this->db->order_by("mf.matchName asc");//sourabh new 161216
					$query = $this->db->get();
					return $query->result_array();
				}
			}
			function getUserMatchOdds($sportId)//sourabh 161227
			{
					if($sportId!=0)//sourabh 170106
					$condition=$this->db->where('mf.SportID', $sportId);
				else
					$condition="";
					$condition1=$this->db->where('mf.active', 1);
				
					$this->db->select("GROUP_CONCAT(ma.Id) as ids");
					$this->db->from('matchmst mf');
					$this->db->join('market ma','ma.matchId=mf.MstCode', 'INNER');
					$condition;
					$condition1;
					$this->db->where('ma.active', '1');
					//$this->db->where('ma.Name', 'Match Odds');//sourabh new 161216
					$this->db->order_by("mf.matchName asc");//sourabh new 161216
					$query = $this->db->get();
					return $query->result_array();
			}
			function getUserMatchResult($useId,$usetype)//sourabh 14-dec-2016
			{
				$query =$this->db->query("call sp_getHomeUserD($useId,$usetype)");
				$res = $query->result_array();
				$query->next_result();
				$query->free_result();
				return $res;
			}
			function GetSeriesFrmDatabase(){
				$this->db->select("*");
				$this->db->from('seriesmst');
				$this->db->where('active', '1');
				$query = $this->db->get();
				return $query->result_array();
			}
			function GetMatchFrmDatabase(){//sourabh 170105
				$this->db->select("*");
				$this->db->from('matchmst');
				$this->db->where('active', '1');
				$query = $this->db->get();
				return $query->result_array();
			}
			 function Get_MatchActive($id){//sourabh 170105
				$this->db->select('active');
				$this->db->from('matchmst');
				$this->db->where('MstCode', $id);
				$query = $this->db->get();
				return $query->result();
			}
			function GetMarketFrmDatabase(){//sourabh 170105
				$this->db->select("*");
				$this->db->from('market');
				$this->db->where('active', '1');
				$query = $this->db->get();
				return $query->result_array();
			}
			 function Get_MarketActive($id){//sourabh 170105
				$this->db->select('active');
				$this->db->from('market');
				$this->db->where('Id', $id);
				$query = $this->db->get();
				return $query->result();
			}
}