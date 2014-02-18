<?php
require '../src/facebook.php';
$facebook = new Facebook(array(
  'appId'  => 'APP_ID',
  'secret' => 'APP_SECRET',
));

$user = $facebook->getUser();
if ($user) {

  try {
 $access_token = $facebook->getAccessToken();
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>filter search</title>
<link rel='stylesheet' href='style_searchbox.css' />
<link rel='stylesheet' href='instantsearchbox.css' />
<script src="jquery-latest.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<style>
#upper{
position:relative;
z-index:1;
}
#drop{
width:580px;
 border:1px solid #c4cde1;
-webkit-border-radius:3px;
-webkit-box-shadow:0 1px 0 0 #d8deeb;
border-spacing: 0px;
background:#FFFFFF;
}
</style>
</head>
<body>
<?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>

<div id="upper" class="searchbox" align="center" >
		<input id="searchterm" class="dim"/>
		<div id="drop">
			<div class="dropdownlist hlight">		
				<div class="pic" >
	<img class="img_instant" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn2/t5/1118700_100001091433956_909940555_q.jpg"/>
				</div>
				<div class="details">
					<div class="details_content_wrap">
					<div class="list_title">Avinash Kumar</div>
					<div class="list_details">Ranchi,Jharkhand</div>
					</div>

				</div>

			</div>
		</div>

</div>
<script src="dropdown.js"></script>
<script>
var token='<?php echo$access_token ?>';
console.log(token);
      $("#searchterm").keyup(function(e){
        var tosearch = $("#searchterm").val();
        $.getJSON("https://graph.facebook.com/search?",
        {
          fields:"picture,name",
          q: tosearch,
          type: "user",
          limit:6,
          access_token: token
        },
        function(data) {
var d=JSON.stringify(data);
console.log(d);
          $("#drop").empty();
          $.each(data.data, function(i,item){
           $("#drop").append('<div class="dropdownlist" onclick="location.href=\'https://www.facebook.com/'+item.id+'\';"><div class="pic" ><img class="img_instant" src="'+item.picture.data.url+'"></img></div><div class="details"><div class="details_content_wrap"><div class="list_title"><a color="red" href="https://www.facebook.com/' + (item.id) + '">' + item.name + '</a></div><div class="list_details">'+ item.id +'</div></div></div></div>');
          });
        });
      });
 
</script>

    <?php else: ?>
      <div>
        <a href="<?php echo $statusUrl; ?>">Check the login status</a>
      </div>
      <div>
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

	
   </div>         
</body>
</html>

