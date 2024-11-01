<?php 
 
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}
global $wpdb;
$tracking_result = '';
$awb_number = null;

if(isset($_POST['submit']))
{
    $awb_number = sanitize_text_field($_POST['tracking_number']);
    if(!empty($awb_number)){
      $sql = "select * from `{$wpdb->base_prefix}webparex_config`";
      $result = $wpdb->get_results($sql);
      $URL = 'https://webparex.in/app/api/v1/track-order?awb_number='.$awb_number;

      $args  = array(
          'headers'=>[
            'public-key'=>$result[0]->public_key,
            'private-key'=>$result[0]->private_key,
          ]
      );
      $response = wp_remote_get( $URL, $args );
      $tracking_result = json_decode($response['body'],true);
      if(isset($tracking_result['result']) &&  $tracking_result['result'] == 0){
        _e("<div class='alert warning'>
              <span class='closebtn'>&times;</span>  
              <strong>Invalid!</strong> Please enter valid tracking number.
          </div>");

      }
    }else{
      _e("<div class='alert warning'>
            <span class='closebtn'>&times;</span>  
            <strong>Invalid!</strong> Tracking number is required.
        </div>");
    }
}
?>


<style>
input[type=number], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.alert.success {background-color: #04AA6D;}

.closebtn {
margin-left: 15px;
color: white;
font-weight: bold;
float: right;
font-size: 22px;
line-height: 20px;
cursor: pointer;
transition: 0.3s;
}

.closebtn {
margin-left: 15px;
color: white;
font-weight: bold;
float: right;
font-size: 22px;
line-height: 20px;
cursor: pointer;
transition: 0.3s;
}
.alert {
padding: 20px;
background-color: #f44336;
color: white;
opacity: 1;
transition: opacity 0.6s;
margin-bottom: 15px;
}

input[type=submit] {
  width: 100%;
  background-color: blue;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: blue;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

</style>

<div>
  <form action="" method="post">
    <label for="fname">Tracking Number</label>
    <input type="number" id="awb_number" name="tracking_number" value="<?php _e($awb_number); ?>" placeholder="Tracking Number" required>
    <input type="submit" value="Track" name="submit">
  </form>
<?php
if(isset($tracking_result['result']) &&  $tracking_result['result'] == 1){
?>
<h6 style="margin:0px; padding:0px;"><strong>Order ID :</strong> <?php _e($tracking_result['data']['order_id']); ?></h6>
<h6 style="margin:0px; padding:0px;"><strong>Refrence ID :</strong> <?php _e($tracking_result['data']['refrence_id']); ?></h6>
<h6 style="margin:0px; padding:0px;"><strong>Tracking Number :</strong> <?php _e($tracking_result['data']['awb_number']); ?></h6>
<h6 style="margin:0px; padding:0px;"><strong>Current Status :</strong> <?php _e($tracking_result['data']['current_status']); ?></h6>
<h6 style="margin:0px; padding:0px;"><strong>Courier :</strong> <?php _e($tracking_result['data']['courier']); ?></h6>
<table>
  <tr>
    <th>Date & Time</th>
    <th>Location</th>
    <th>Status</th>
  </tr>
<?php 
if($tracking_result['data']['scan_detail'] != ''){
    foreach($tracking_result['data']['scan_detail'] as $data){
?>
  <tr>
    <td><?php _e($data['date']); ?></td>
    <td><?php _e($data['location']); ?></td>
    <td><?php _e($data['status']); ?></td>
  </tr>
<?php 
    }
}
?>
</table>

<?php
}
?>
</div>
<script>
var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
  close[i].onclick = function(){
    var div = this.parentElement;
    div.style.opacity = "0";
    setTimeout(function(){ div.style.display = "none"; }, 600);
  }
}
</script>



