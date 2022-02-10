let password=document.querySelectorAll("#pwd");
let showPassword= document.getElementById("showPassword");
let show_password_hide=document.getElementById("show_password_hide");

showPassword.addEventListener("click", function(){
    password.forEach(pwd=>{
        if(pwd.type == 'password'){
            pwd.type = "text";
            show_password_hide.textContent="Hide Password";
        }else{
            pwd.type='password';
            show_password_hide.textContent="Show Password";
        } 
    }) 
} );