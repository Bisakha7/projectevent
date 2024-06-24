




function get_bookings() {

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/bookings_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


  xhr.onload = function() {
    document.getElementById('bookings_data').innerHTML = this.responseText;
  }
  xhr.send('get_bookings');

}

window.onload = function() {
  get_bookings();
}


function toggleStatus(id, val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/bookings_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


  xhr.onload = function() {
    if (this.responseText == 1) {
      alert('success', 'Booking is Confirmed');
      get_bookings();
    } else {
      alert('error', 'Booking is in pending');
    }
  }
  xhr.send('toggleStatus=' + id + '&value=' + val);


}



function delete_booking(booking_id){
  if(confirm("Are you sure you want to delete booking?")){
    let data = new FormData(); 
  data.append('booking_id', booking_id); 
  data.append('delete_booking', ''); 
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/bookings_crud.php", true);

  xhr.onload = function() {
   

    if (this.responseText == '1') {
      alert('success', 'Booking has been removed');
      get_bookings();
    }  else {
      alert('error', 'Unable to remove booking');
     

    }
  }
  xhr.send(data);

  }
 

 
  
}









