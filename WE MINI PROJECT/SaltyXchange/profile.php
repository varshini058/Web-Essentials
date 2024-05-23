<?php

include 'config.php';

session_start();

$user_id = $_SESSION['userid'];
if(!isset($user_id)){
    header('location:login.php');
 }
 
if(isset($_POST['add_recipe'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $instruction = mysqli_real_escape_string($conn, $_POST['instruction']);
    $ingredient = mysqli_real_escape_string($conn, $_POST['ingredient']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'images/'.$image;
    $video=mysqli_real_escape_string($conn,$_POST['video']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $subcategory = mysqli_real_escape_string($conn, $_POST['subcategory']);
 
    $select_recipe_name = mysqli_query($conn, "SELECT name FROM `recipes` WHERE name = '$name'") or die('query failed');
 
    if(mysqli_num_rows($select_recipe_name) > 0){
       $message[] = 'Recipe already added';
    }else{
       $add_recipe_query = mysqli_query($conn, "INSERT INTO `recipes`(user_id,name,description,instruction,ingredients,image,video,category,subcategory) VALUES($user_id,'$name', '$description','$instruction','$ingredient', '$image','$video','$category','$subcategory')") or die('query failed');
 
       if($add_recipe_query){
          if($image_size > 2000000){
             $message[] = 'image size is too large';
          }else{
             move_uploaded_file($image_tmp_name, $image_folder);
             $message[] = 'Recipe added successfully!';
          }
       }else{
          $message[] = 'Recipe could not be added!';
       }
    } 
 }
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `recipes` WHERE recipe_id = '$delete_id'") or die('query failed');
    header('location:profile.php');
 }
 if(isset($_POST['update_recipe'])){

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_description = $_POST['update_description'];
    $update_instruction = $_POST['update_instruction'];
    $update_ingredient = $_POST['update_ingredient'];
    $update_category=$_POST['update_category'];
    $update_subcategory=$_POST['update_subcategory'];
 
    mysqli_query($conn, "UPDATE `recipes` SET name = '$update_name', description = '$update_description' , instruction='$update_instruction', ingredients='$update_ingredient' , category='$update_category', subcategory='$update_subcategory' WHERE recipe_id = '$update_p_id'") or die('query failed');
 
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'images/'.$update_image;
    $update_old_image = $_POST['update_old_image'];
 
    if(!empty($update_image)){
       if($update_image_size > 2000000){
          $message[] = 'image file size is too large';
       }else{
          mysqli_query($conn, "UPDATE `recipes` SET image = '$update_image' WHERE recipe_id = '$update_p_id'") or die('query failed');
          move_uploaded_file($update_image_tmp_name, $update_folder);
          unlink('images/'.$update_old_image);
       }
    }
    header('location:profile.php');
}
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recipe</title>
 
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 
    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
 
 </head>
 <body>
    
 <?php include 'header.php'; ?>
 <section class="profile">
 <?php  
         $select_users = mysqli_query($conn, "SELECT * FROM `users` where user_id=$user_id") or die('query failed');
         if(mysqli_num_rows($select_users) > 0){
            while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
    <div class="profile-content">
        <div class="imgbox">
        <img src="profileimg.jpg" height="350px" width="250px"/>
        </div>
        <div class="profile-name">
            <p>Name : <?php echo $fetch_users['username']?></p>
            <p>Email : <?php echo $fetch_users['email']?></p>
            <button class="btn-logout"><a href="logout.php">Logout</a></button>
        </div>
    </div>
    <?php
         }
      }else{
         echo '<p class="empty">Our chefs are cooking!</p>';
      }
      ?>
 </section>
 <section class="recipes">
 <h1>Your Recipes</h1>
    <div class="card-container">
    <?php  
         $select_recipes = mysqli_query($conn, "SELECT * FROM `recipes` where user_id=$user_id") or die('query failed');
         if(mysqli_num_rows($select_recipes) > 0){
            while($fetch_recipes = mysqli_fetch_assoc($select_recipes)){
      ?>

      <div class="card">
      <img src="images\<?php echo $fetch_recipes['image']; ?>" height="150px" width="150px" alt="image" style="object-fit:fill;">
      <p class="name" style="font-size:40px;color:blueviolet;font-weight:bold;"><?php echo $fetch_recipes['name']; ?></p>
      <button class="btn-edit"><a href="profile.php?update=<?php echo $fetch_recipes['recipe_id']; ?>">Edit</a></button>
      <button class="btn-delete"><a href="profile.php?delete=<?php echo $fetch_recipes['recipe_id']; ?>" onclick="return confirm('Delete this recipe?');">Delete</a></button>
      </div>
    <?php
         }
      }else{
         echo '<p class="empty">Cook something new and Share Today!</p>';
      }
      ?>
      </div>
 </section>
 <section class="add-recipes">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Cook Something New</h3>
      <input type="text" name="name" class="box" placeholder="Enter recipe name" required>
      <textarea name="description" class="box" placeholder="Enter description" required></textarea>
      <textarea name="instruction" class="box" placeholder="Enter instruction" required></textarea>
      <textarea name="ingredient" class="box" placeholder="Enter ingredients" required></textarea>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="text" name="video" class="box" placeholder="Enter recipe video link" class="box">
      <select id="category" class="box" name="category">
      <option value="veg">Vegetarian</option>
      <option value="nonveg">Non-Vegetarian</option>
      </select>
      <select id="subcategory" class="box" name="subcategory">
      <option value="southindian">South Indian</option>
      <option value="northindian">North Indian</option>
      <option value="italian">Italian</option>
      <option value="chinese">Chinese</option>
      <option value="mexican">Mexican</option>
      </select>
      <input type="submit" value="Add Recipes" name="add_recipe" class="btn">
   </form>

</section>
<section class="edit-recipe-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `recipes` WHERE recipe_id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['recipe_id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="images/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter recipe name">
      <textarea name="update_description"class="box" required placeholder="Enter recipe description"> <?php echo $fetch_update['description']; ?> </textarea>
      <textarea name="update_instruction"class="box" required placeholder="Enter recipe instruction"><?php echo $fetch_update['instruction']; ?></textarea>
      <textarea name="update_ingredient" class="box" required placeholder="Enter recipe ingredient"> <?php echo $fetch_update['ingredients']; ?> </textarea>
      <input type="text" name="update_category" value="<?php echo $fetch_update['category']; ?>"  class="box" required placeholder="Enter recipe category">
      <input type="text" name="update_subcategory" value="<?php echo $fetch_update['subcategory']; ?>"  class="box" required placeholder="Enter recipe subcategory">
      <input type="text" name="update_video" value="<?php echo $fetch_update['video']; ?>"  class="box" placeholder="Enter video link">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_recipe" class="btn-edit">
      <input type="reset" value="cancel" id="close-update" class="btn-delete">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-recipe-form").style.display = "none";</script>';
      }
   ?>

</section>
<script src="script.js"></script>
 </body>
 </html>