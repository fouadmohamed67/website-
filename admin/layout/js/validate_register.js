 
  function validate_re()
  {
      var counter=0;
    
    if( document.form.name.value == "" ) {
        document.getElementById("error_name").style.display = "block";
        document.getElementById("error_name").innerHTML = "the name is required" ;
        counter++;
    }
    if( document.form.email.value == "" ) {
        
        document.getElementById("error_email").style.display = "block";
        document.getElementById("error_email").innerHTML = "the email is required" ;
        counter++;
     }
     if( document.form.password.value.length <6 ) {
        
        document.getElementById("error_password").style.display = "block";
        document.getElementById("error_password").innerHTML = "the password is short " ;
        counter++;
     }
     if( document.form.password.value != document.form.confirm.value  ) {
        
        document.getElementById("error_confirm").style.display = "block";
        document.getElementById("error_confirm").innerHTML = "the two passwords not identical" ;
        counter++;
     }
     if(counter>0)
     {
         return false;
     }
  }