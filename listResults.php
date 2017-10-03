<?php  
 //pagination.php  
 $connect = mysqli_connect("localhost", "LAUser", "LApass", "LARanking");  
 
 
 $eval ='cite';
 $type ='journals';

 $queryType="";
 $querySort="";
 
 if(strcmp($eval,'cite')==0){
 	$querySort="CiteScore";
 }
 elseif(strcmp($eval,'top')==0){
 	$querySort="CiteScore";
 }
 else{
 	echo "Error in Data";
 }
 
  if(strcmp($type,'journals')==0){
 	$queryType="Journal";
 }
 elseif(strcmp($type,'conferences')==0){
 	$queryType="Conference Proceedings";
 }
 else{
 	echo "Error in Data";
 }
 
 
 if ($connect) {
 $record_per_page = 20;  
 $page = '';  
 $output = '';  
 if(isset($_POST["page"]))  
 {  
      $page = $_POST["page"];  
 }  
 else  
 {  
      $page = 0;  
 }  
 $start_from = $page;  
 $query = "SELECT Title,CiteScore,Percent_Cited,Year  FROM cite_score where type='" . $queryType . "' ORDER by " . $querySort . " DESC LIMIT $start_from, $record_per_page";  
 $result = mysqli_query($connect, $query);  
 if(!$result){
 	echo mysqli_error($connect);
 }
 $output .= "  
      <ul class='resultList'>  
 ";  
 while($row = mysqli_fetch_array($result))  
 {  
      $output .= '  
           <li class="resultItem"> 
           		<div style="display:block; float:left; text-align:left;">
           	    <div class="resultTitle" style="font-weight:bold;">'.$row["Title"].'</div>
           	    <div class="resultCiteScore">CiteScore '.$row["CiteScore"].'</div>
           	    <div class="resultPercent_Cited">PercentageCited '.$row["Percent_Cited"].'</div>
           	    </div>
           	    <div class="resultYear" style="float:right;">'.$row["Year"].'</div>
           	    <div style="clear:both"></div>
           	   	
				
           </li>  
      ';  
 }  
 $output .= '</ul>';  
 $page_query = "SELECT Title,CiteScore,Percent_Cited,Year  FROM cite_score where type='" . $queryType . "' ORDER by " . $querySort . " DESC";  
 $page_result = mysqli_query($connect, $page_query);  
 $total_records = mysqli_num_rows($page_result);  
 $total_pages = min(ceil($total_records/$record_per_page));  
 
 $output .="<span class='text'>".$page." - ".min(($page+$record_per_page),$total_records)." of ".$total_records."</span>";
 
 if($page==0){
 	 $output .= "<span class='pagination_link_deactivated fa fa-chevron-left' style='cursor:pointer; padding:6px; border:1px solid #ccc;color:red' id='".($page-$record_per_page)."'></span>";  
 }
 else{
 	 $output .= "<span class='pagination_link fa fa-chevron-left' style='cursor:pointer; padding:6px; border:1px solid #ccc;' id='".($page-$record_per_page)."'></span>";  
 }
 if(($page+$record_per_page)<$total_pages){
 	 	 $output .= "<span class='pagination_link_deactivated fa fa-chevron-right' style='cursor:pointer; padding:6px; border:1px solid #ccc;color:red;' id='".($page+$record_per_page)."'></span>";  			
 }else{
 	 	 $output .= "<span class='pagination_link fa fa-chevron-right' style='cursor:pointer; padding:6px; border:1px solid #ccc;' id='".($page+$record_per_page)."'></span>";  
 }
$output .= '</div><br /><br />';  
 echo $output;
} else {
  echo 'not conected';
}

   
 ?>