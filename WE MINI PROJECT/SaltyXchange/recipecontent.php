<?php

include 'config.php';

session_start();

$user_id = $_SESSION['userid'];
if(!isset($user_id)){
    header('location:login.php');
 }
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'bookmark') {
    // Insert the bookmark into the database
    $recipeId = $_POST['recipe_id'];
    $select_recipe_name = mysqli_query($conn, "INSERT into `bookmarks` (user_id,recipe_id) VALUES ($user_id,$recipeId)") or die('query failed');
    if($select_recipe_name){
        $message[] = 'Bookmark added';
     }
    else{
        $message[] = 'Bookmark could not be added!';
    }
    header('Location: http://localhost/SaltyXchange/recipecontent.php?recipeid='.$recipeId );
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'like') {
    $recipeId = $_POST['recipe_id'];
    $like_recipe = mysqli_query($conn, "UPDATE `rceipes`set likes=likes+1 where recipe_id=$recipeId") or die('query failed');
    if($like_recipe){
        $message[] = 'Likes';
     }
    else{
        $message[] = 'Disliked';
    }
}
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe</title>
 
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 
    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
 
 </head>
 <body>
    
 <?php include 'header.php'; ?>
 
 <div class="heading">
    <h3>Recipe</h3>
    <p> <a href="home.php">Home</a> / Recipe Instruction </p>
 </div>
 
 <section class="products">
 
    <?php  
    if(isset($_GET['recipeid'])){
        $res_id=mysqli_real_escape_string($conn, $_GET['recipeid']);
         $select_recipes = mysqli_query($conn, "SELECT * FROM `recipes` where recipe_id=$res_id ") or die('query failed');
         if(mysqli_num_rows($select_recipes) > 0){
            while($fetch_recipes = mysqli_fetch_assoc($select_recipes)){
                $userid = $fetch_recipes['user_id'];
        $username_query = "SELECT username FROM users WHERE user_id = $userid";
        $username_result = mysqli_query($conn, $username_query);

        if($username_result && mysqli_num_rows($username_result) > 0) {
            $username_row = mysqli_fetch_assoc($username_result);
            $username = $username_row['username'];
        } else {
            $username = "Unknown";
        }
        $likes_query="SELECT count(likes) from recipes where recipe_id=$res_id";
        $likes=mysqli_query($conn,$likes_query);
        
      ?>
    <div class="recipecontent">
            <div class="imgbox">
                <img src="images\<?php echo $fetch_recipes['image']; ?>" class="image" alt="image">
            </div>
            <div class="box">
                <h1><?php echo $fetch_recipes['name'];?></h1>
                <p><?php echo $fetch_recipes['description'];?></p>
                <div class="username">
                    <i class="fa-regular fa-user" style="font-size: 30px;margin-right:5px;"></i>
                    <h3 style="font-size:30px;"><?php echo $username?></h3>
                    <span class="like-icon" onclick="likeRecipe()" style="cursor: pointer;">
                    <i class="fa-regular fa-heart" id="heart" style="margin-left:440px;font-size:30px;"></i>
                    </span>
                    <form id="likeForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="display: none;">
                    <input type="hidden" name="action" value="like">
                    <input type="hidden" name="recipe_id" value="<?php echo $fetch_recipes['recipe_id']; ?>">
                    </form>
                    <span class="bookmark-icon" onclick="bookmarkRecipe()" style="cursor: pointer;">
                    <i class="fa-regular fa-bookmark" id="bookmark" style="margin-left:20px;font-size:30px;"></i>
                    </span>
                    <form id="bookmarkForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="display: none;">
                    <input type="hidden" name="action" value="bookmark">
                    <input type="hidden" name="recipe_id" value="<?php echo $fetch_recipes['recipe_id']; ?>">
                    </form>
            </div>
            </div>
    </div>
    <div class="content">
    <div class="ing-card">
    <div class="ingredients">
        <h1>Ingredients</h1>
        <ul class="list-ingredients">
        <?php 
         $ingredients_list = explode("\n", $fetch_recipes['ingredients']);
         foreach($ingredients_list as $ingredient): ?>
            <li><?php echo trim($ingredient);?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    </div>
    <div class="inst-card">
    <div class="instructions">
        <h1>Preparation Instruction</h1>
        <ul>
        <?php 
         $instruction = explode("\n", $fetch_recipes['instruction']);
         foreach($instruction as $ins): ?>
            <li><?php echo trim($ins);?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    </div>
    </div> 
    <div class="video-card">
        <a href="<?php echo $fetch_recipes['video']?>" style="color:darkred";>Are you someone who need a video tutorial ? Watch recipe video here. Click on this text.</a>
    </div>   
      <?php
         }
      }else{
         echo '<p class="empty">No recipes found!</p>';
      }
    }
      ?>
                 
                     
 
 </section>
 <script src="script.js"></script>
 </body>
 </html>
 