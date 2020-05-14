function validate_edit()
{
    var counter=0;
  
   
  if( document.form.name.value == "" ) {
      
      document.getElementById("error_name_edit").style.display = "block";
      document.getElementById("error_name_edit").innerHTML = "the name is required" ;
      counter++;
   }
   if( document.form.email.value == "" ) {
      
    document.getElementById("error_email_edit").style.display = "block";
    document.getElementById("error_email_edit").innerHTML = "the email is required" ;
    counter++;
 }
    
   if(counter>0)
   {
       return false;
   }
}