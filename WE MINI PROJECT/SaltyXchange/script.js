let userBox = document.getElementById('user-btn');
let navbar = document.querySelector('.header .header-2 .navbar');
document.querySelector('#close-update').onclick = () =>{
    document.querySelector('.edit-recipe-form').style.display = 'none';
    window.location.href = 'profile.php';
 }
userBox.onclick = () =>{
   userBox.style.display="inline-block";

}
function bookmarkRecipe() {
   // Trigger form submission
   document.getElementById("bookmarkForm").submit();
}
function likeRecipe() {
   // Trigger form submission
   document.getElementById("likeForm").submit();
}
