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
    <title>Search</title>
 
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 
    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
    <style>
      .search-form form {
         max-width: 1200px;
         margin: 30px auto;
         display: flex;
         gap: 15px;
      }

      .search-form form .search_btn {
         margin-top: 0;
      }

      .search-form form .box {
         width: 100%;
         padding: 12px 14px;
         border: 2px solid darkred;
         font-size: 20px;
         color: black;
         border-radius: 5px;
      }

      .search_btn {
         display: inline-block;
         padding: 10px 25px;
         cursor: pointer;
         color: white;
         font-size: 18px;
         border-radius: 5px;
         text-transform: capitalize;
         background-color: darkred;
      }
   </style>
 </head>
 <body>
 <?php include 'header.php'; ?>
 <section class="search-form">

      <form action="" method="POST">
         <input type="text" class="box" name="search_box" placeholder="search recipes...">
         <input type="submit" name="search_btn" value="search" class="search_btn">
      </form>
      </section>
      <div class="msg">
      <?php
      if (isset($_POST['search_btn'])) {
         $search_box = $_POST['search_box'];
         
         echo '<h4>Search Result for "'. $search_box.'"is:</h4>';
      };
      ?>
   </div>
   <section class="recipes">

   <div class="box-container">

      <?php  
      if (isset($_POST['search_btn'])) {
        $search_box = $_POST['search_box'];
        $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
         $select_recipes = mysqli_query($conn, "SELECT * FROM `recipes` WHERE name LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%' OR subcategory LIKE '%{$search_box}%'") or die('query failed');
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
         echo '<p class="empty">Could not find "'. $search_box.'"!</p>';
      }
    };
      ?>
   </div>

</section>

 </body>
 </html>