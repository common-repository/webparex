<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $wpdb;

if(isset($_POST['submit']))
{
    $public_key = sanitize_text_field($_POST['public_key']);
	$private_key = sanitize_text_field($_POST['private_key']);
    if(!empty($public_key) && !empty($private_key)){
        $delete_query = "DELETE FROM `{$wpdb->base_prefix}webparex_config`";
        $wpdb->query($delete_query);
        
        $sql = "INSERT INTO `{$wpdb->base_prefix}webparex_config`
        (`public_key`,`private_key`) 
        values ('$public_key','$private_key')";
        $wpdb->query($sql);

        _e("<div class='alert success'>
            <span class='closebtn'>&times;</span>  
            <strong>Success!</strong> data update successfully.
        </div>");
    }else{
        _e("<div class='alert warning'>
            <span class='closebtn'>&times;</span>  
            <strong>Invalid!</strong> Please enter valid details.
        </div>");
    }

}
  
?>
<style>
    .alert.success {background-color: #04AA6D;}

    .closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 16px;
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
  padding: 15px;
  background-color: #f44336;
  color: white;
  opacity: 1;
  transition: opacity 0.6s;
  margin-bottom: 15px;
  width:95%;
}
</style>
<h2>Webparex</h2>
<?php
$sql = "select * from `{$wpdb->base_prefix}webparex_config`";
$result = $wpdb->get_results($sql);
?>
<form method="post" id="form1" action="">
<h2>Configuration</h2>
        <a href="https://app.webparex.in/user/register" target="_blank" style="background-color: #2eade0;color: #ffffff;text-decoration: none;padding: 4px;border: thin solid #ababab;">Register here</a> 
        <span style="font-size:14px;">for free courier tracking.</span> 
        <table class="form-table" role="auth">
            <tbody>
                <tr>
                    <th scope="row">Public Key</th>
                        <td>
                            <input type="text" id="title" name="public_key" value="<?php _e(isset($result[0]->public_key)?$result[0]->public_key:''); ?>" required="required">
                        </td>
                </tr>
                <tr>
                    <th scope="row">Private Key</th>
                        <td>
                            <input type="text" id="title" name="private_key" value="<?php _e(isset($result[0]->private_key)?$result[0]->private_key:''); ?>" required="required">
                        </td>
                </tr>
                </tbody>
            </table>
        <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-success" style="background:green; color:white;" value="Save Changes">
        </p>						
</form>
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
