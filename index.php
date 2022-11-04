<?php
$host="localhost";
$user="root";
$pass="";
$databas="location";

$link=mysqli_connect($host,$user,$pass,$databas);
if(!$link){
    echo "can't connection MySQL";
    exit();
}
?>

<!doctype html>
<html>
  <head>
          <meta charset="utf-8">
          <title>loction UD</title>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <div class="container-fluid p-5 bg-secondary text-white text-center">
        <img class="float-start" src="—Pngtree—earthen jar exotic style jar_5765140.png" width="150" height="150" frameborder="0" style="border:0;">
        <img class="float-end" src="—Pngtree—earthen jar exotic style jar_5765140.png" width="150" height="150" frameborder="0" style="border:0;">
        <h1>สถานที่ในจังหวัดอุดรธานี</h1>
        <p>Places in Udon Thani Province</p>  
    </div>
    <form method="get" id="form" enctype="multipart/form-data" action="">
    <div class="container mt-3" style="">
      <div class="input-group mb-3">
          <input  class="form-control" placeholder="ค้นหาข้อมูล" name="search" >
          <button class="btn btn-success" type="submit" >ค้นหาข้อมูล</button>
          <button class="btn btn-danger" type="submit" value="" href="location.php">สถานที่ทั้งหมด</button>
      </div>

      <?php 
          if(isset($_GET['search'])){
            $search=$_GET['search'];
            $sql="select * from lo where Name LIKE '%$search%'";
          } else{
            $sql = "SELECT * FROM lo";
                        

          }
        ?>     
        <?php
        $query = mysqli_query($link, $sql);
        while($result = mysqli_fetch_assoc($query)){ ?> 

      <div class="card" style="width:400px margin:0px auto;">
        <div class="card-body">
              <h3 class="text-danger"><?=$result["Name"]?></h3>
              <h5 class="card-text"><?=$result["Detail"]?></h5>
              <h5 class="text-info"><?=$result["County"]?></h5>
              <!-- ใส่รูปภาพและกำหนดขนาด -->
              <img class="float-start"src="<?=$result["img"] ?>" width="600" height="360" frameborder="0" style="border:0;">

          <?php
            
          // ดึง plus code from plus code api
          $lat = $result["la"];
          $lng = $result["long"];
          $str = file_get_contents("https://plus.codes/api?address=$lat,$lng&ekey=AIzaSyBOtQTtAbg0Rfl7RQ1WPjEjPw6Pg5pu9TA&email=domezaza48@gmail.com");
          $json = json_decode($str, true);
          $post_code = strval($json["plus_code"]["global_code"]);
            
          // แปลง + เป็น %2B 
          $myArray = explode('+', $post_code);
          $str = $myArray[0] . "%2B" . $myArray[1];
          $str = trim($str); // ลบช่องว่าง
          ?>

            <!-- กำหนดขนาดแผนที่ -->
            <iframe class="float-end" width="600" height="360" frameborder="0" style="border:0;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBOtQTtAbg0Rfl7RQ1WPjEjPw6Pg5pu9TA&q=<?php echo $str; ?>&center=<?php echo $result["la"]; ?> ,<?php echo $result["long"]; ?>" allowfullscreen>
            </iframe> </a> 
          </div>
          </div>
          <br>
          <?php } ?>
      </div>
    </div>
  </body>
</html>