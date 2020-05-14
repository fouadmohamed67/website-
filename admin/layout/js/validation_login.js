 
 function validation_login()
 {
     var counter=0;
     if( document.form.email.value == "" ) {
        document.getElementById("error_email").style.display = "block";
        document.getElementById("error_email").innerHTML = "the email is required" ;
        counter++;
    }
    if( document.form.password.value == "" ) {
        document.getElementById("error_password").style.display = "block";
        document.getElementById("error_password").innerHTML = "the password is required" ;
        counter++;
    }
    if(counter>0)
    {
        return false;
    }
 }