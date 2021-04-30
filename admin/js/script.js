function confirmDelete(event){

  event.preventDefault();


  var userPickedVal = confirm('Do You Want To Delete This Row');
  if(userPickedVal){
      window.location = jQuery(event.target).attr('href');
  }

}
     