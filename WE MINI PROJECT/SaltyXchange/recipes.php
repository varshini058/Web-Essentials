<?php

include 'config.php';

session_start();

$user_id = $_SESSION['userid'];

if(!isset($user_id)){
   header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Recipes</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
<?php include 'header.php'; ?>
<div class="heading">
   <h3>Recipes</h3>
   <p> <a href="home.php">Home</a> / Recipes </p>
</div>
<section class="recipes">

   <div class="box-container">

      <?php  
         $select_recipes = mysqli_query($conn, "SELECT * FROM `recipes` order by likes desc") or die('query failed');
         if(mysqli_num_rows($select_recipes) > 0){
            while($fetch_recipes = mysqli_fetch_assoc($select_recipes)){
      ?>
     <form action="" method="post" class="box">
      <img src="images\<?php echo $fetch_recipes['image']; ?>" class="image" alt="image">
      <div class="name"></a><?php echo $fetch_recipes['name']; ?></div>
      <div class="description"><?php echo $fetch_recipes['description']; ?></div>
      <a href="recipecontent.php?recipeid=<?php echo $fetch_recipes['recipe_id']; ?>" class="cook-btn">Cook</a>
    </form>
      <?php
         }
      }else{
         echo '<p class="empty">Our chefs are cooking!</p>';
      }
      ?>
   </div>

</section>

</body>
</html>