<!doctype html> 
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  
   
        <title>Laravel</title>
    </head>
    <body>
        <div class="container-fluid" style="min-height: 1000px;border: 25px solid orange;padding: 100px; border-bottom: hidden "> 
        	<h1 style="color:orange ;text-align:center; margin-bottom: 40px ">Your Feedbacks</h1>
        	<div style="margin-bottom:-10;margin-bottom:-10px">  
              <?php $__currentLoopData = $user_feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
              <?php
                    $temp = $user->raitng;
                    
              ?> 
               <div class="col-sm-12" >
               	<div>
               		
               		<div class="row" style="margin-bottom: 0px; padding: 0px">
               			<div class="col-sm-6" style="">
               				<span class="badge badge-secondary" style="  padding: 26px 17px; border-radius: 30px; background-color: orange; margin-right: 40px">User</span> 
               			</div>
               			<div class="col-sm-6" style="margin-left: 60px">
               				<div class=""row>
               					<div class="col-sm-6">
               						<span ><b>CompanyUser</b></span>

               					</div>
               					<div class="col-sm-6">
                          
                          <?php for($i=0;$i<$temp;$i++): ?>
                          * 
                          <?php endfor; ?> 
               						<!-- <span style="margin-top: 40px" ><?php echo e($user->raitng); ?></span> -->
               					</div>
                        <div style="margin-left:15px;margin-top:10px">
                        <?php echo e($user->feedback); ?> 
                       </div>
               				</div> 
                       
               			</div>

               		</div> 
                 
                  
                 </div>
        			 <hr style="margin-top:-40px"> 
        			 <br>
                  </div> 
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        	</div> 
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body> 
    <script> 
function getRndInteger(min, max) {
    var z = Math.floor(Math.random() * (max - min + 1) ) + min;
    y = 5 ;
  document.getElementById("sRand").innerHTML = 5+6;';'
   
}
</script>

</html>



