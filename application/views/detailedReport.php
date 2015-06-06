</script>
<h2>Detailed Test Report</h2>

<br/>
<table align="center" border='1' cellspacing='0' cellpadding='20'>
    <tr><td colspan="4" align="center"><b>Crossover Pathology and Diagnostic Center</b></td>
</tr>
<tr>
    <td><B>Patient Details</B></td><td colspan="3" Align="right"><a href='#'>Export To PDF</a><br/><a href='#'>Send To Registered Email</a></td>
</tr>
<tr>
    <td >Name</td><td colspan='3'><?=$result['userdata']['first_name']." ".$result['userdata']['last_name'];?></td>
</tr>
<tr>
    <td>Age</td><td><?=$result['userdata']['age']?> </td>
    <td>Gender</td><td><?=$result['userdata']['gender']?></td>
</tr>
<tr>
    <td>Mobile</td><td><?=$result['userdata']['mobile']?></td>
    <td>Email</td><td><?=$result['userdata']['email']?></td>
</tr>
</table>
<br/>
<table align="center" border='1' cellspacing='0' cellpadding='5'>
<thead>
    <tr>
        <th>Ser. No.</th>
        <th>Test Name</th>
        <th>Test Result</th>
        <th>Test Min. Value</th>
        <th>Test Max. Value</th>
        <th>Test Cost</th>
        <th>Test Completeness Status</th>
    </tr>
</thead>
   <?php
   echo('<pre>');
   //print_r($result);
   $i=1;
   foreach($result['testdata'] as $k=>$v){
        echo "<tr>";
         echo "<td>";
          echo $i++;
          echo "</td><td>";
          echo $v['test_name'];
          echo "</td><td>";
          echo $v['test_result'];
          echo "</td><td>";
          echo $v['test_min_value'];
          echo "</td><td>";
          echo $v['test_max_value'];
          echo "</td><td>Rs. ";
          echo $v['test_cost'];
          echo "</td><td>";
          echo ($v['status']=="SUCCESS"?"Completed":"In Processing");
          echo "</td>";
         echo "</tr>";
   }
   
   
   ?>
</table>
</br>

