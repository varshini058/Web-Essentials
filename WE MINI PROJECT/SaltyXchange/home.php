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
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php include 'header.php'; ?>
<section class="home">

   <div class="content1">
      <h3>Authentic food Crafted to your taste.</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p>
      <a href="about.php" class="white-btn">Explore</a>
   </div>

</section>
<section class="recipes">

   <h1 class="title">Recipes</h1>

   <div class="box-container">

      <?php  
         $select_recipes = mysqli_query($conn, "SELECT * FROM `recipes` order by likes LIMIT 4") or die('query failed');
         if(mysqli_num_rows($select_recipes) > 0){
            while($fetch_recipes = mysqli_fetch_assoc($select_recipes)){
      ?>
     <form action="" method="post" class="box">
      <img src="images\<?php echo $fetch_recipes['image']; ?>" class="image" alt="image">
      <div class="name"></a><?php echo $fetch_recipes['name']; ?></div>
      <div class="description"><?php echo $fetch_recipes['description']; ?></div>
      <a href="recipes.php" class="cook-btn">Cook</a>
    </form>
      <?php
         }
      }else{
         echo '<p class="empty">Our chefs are cooking!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="recipes.php" class="option-btn">Load more</a>
   </div>

</section>
<script src="script.js"></script>
</body>
</html>