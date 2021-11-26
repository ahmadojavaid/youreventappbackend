<!DOCTYPE html>
<html>
<head>

</head>
<body>
<div class="main">
    <p><strong><img src={{$logo}} caption="false" width="209" height="39"/></strong></p>
    <br/><br/>
    <p><strong><span style="font-size: 12pt;">Dear <?php echo $data1[0]['sponsorName']?>,</span></strong></p>
    <p>Your Login details are as follows:</p>
    <p ><center><span  style="font-size: 10pt;"><em><strong>email : <?php echo $data1[0]['email'] ?></strong></em></span></center></p>
    <p><center><span style="font-size: 10pt;"><em><strong>password : <?php echo$data1[0]['password'] ?> </strong></em></span></center></p>
    <br/><br/>
    <p><strong>Thanks</strong></p>
    <p>TinTech Support Team<br/><span style="color: #339966;"><a href="mailto:TinTech@support.com" target="_blank"
                                                                 style="color: #339966;">support@TinTech.com</a></span>
    </p>
</div>
</body>
</html>