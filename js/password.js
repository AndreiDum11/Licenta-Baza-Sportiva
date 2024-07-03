const togglePassword = document.querySelector('#togglePassword');
const togglePassword1 = document.querySelector('#togglePassword1');
const password = document.querySelector('#password');
togglePassword.addEventListener("click",function(){
        const type =password.getAttribute("type")==="password"?"text":"password";
        password.setAttribute("type",type);
        this.classList.toggle("bx-lock-open");
});
const password1 = document.querySelector('#password1');
togglePassword1.addEventListener("click",function(){
        const type =password1.getAttribute("type")==="password"?"text":"password";
        password1.setAttribute("type",type);
        this.classList.toggle("bx-lock-open");
});
const form = document.querySelector(".form");
form.addEventListener('submit',function(e){
       e.preventDefault();
});
const form1 = document.querySelector(".form1");
form1.addEventListener('submit',function(e){
       e.preventDefault();
});