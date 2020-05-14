function validation_add_book()
{
    var counter=0;
  
   
  if( document.form.name.value == "" ) {
      
      document.getElementById("error-name-book").style.display = "block";
      document.getElementById("error-name-book").innerHTML = "the name is required" ;
      counter++;
   }
   if( document.form.details.value == "" ) {
      
    document.getElementById("error-details-book").style.display = "block";
    document.getElementById("error-details-book").innerHTML = "the details is required" ;
    counter++;
   }
   if( document.form.auther.value == "" ) {
      
    document.getElementById("error-auther-book").style.display = "block";
    document.getElementById("error-auther-book").innerHTML = "the auther name is required" ;
    counter++;
   }
   if( document.form.publication_year.value == "" ) {
      
    document.getElementById("error-date-book").style.display = "block";
    document.getElementById("error-date-book").innerHTML = "the date is required" ;
    counter++;
   }
   

   if(counter>0)
   {
       return false;
   }
}