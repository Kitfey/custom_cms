jQuery(document).ready(function() { 
  
  
//  CKEDITOR
  ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        });
//  END CKEDITOR  
  
//  <->
  
//  Checkboxes
jQuery('#selectAllBoxes').click(function(event) {
  
  if(this.checked) {
    jQuery('.checkBoxes').each(function(){
      
      this.checked = true;
      
    });
  } else {
    jQuery('.checkBoxes').each(function(){
      
      this.checked = false;
      
    });
  }
                                
});
//  END Checkboxes
     
  

  
});
                  
      
function loadUsersOnline() {
  jQuery.get('functions.php?onlineusers=result', function(data){
    
    jQuery('.usersonline').text(data);
    
  });
}  

setInterval(function(){
  loadUsersOnline();
}, 500);
    
                  
                

