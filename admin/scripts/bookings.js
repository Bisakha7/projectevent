




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



// function delete_booking(booking_id){
//   if(confirm("Are you sure you want to delete booking?")){
//     let data = new FormData(); 
//   data.append('booking_id', booking_id); 
//   data.append('delete_booking', ''); 
//   let xhr = new XMLHttpRequest();
//   xhr.open("POST", "ajax/bookings_crud.php", true);

//   xhr.onload = function() {
   

//     if (this.responseText == '1') {
//       alert('success', 'Booking has been removed');
//       get_bookings();
//     }  else {
//       alert('error', 'Unable to remove booking');
     

//     }
//   }
//   xhr.send(data);

//   }
 

 
  
// }

function delete_booking(booking_id) {
  // Open the confirmation modal
  let confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'), {
    backdrop: 'static',
    keyboard: false
  });
  confirmModal.show();

  // Set up the confirmation button
  document.getElementById('confirmDeleteButton').onclick = function() {
    let data = new FormData();
    data.append('booking_id', booking_id);
    data.append('delete_booking', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/bookings_crud.php", true);

    xhr.onload = function() {
      confirmModal.hide();
      if (this.responseText.trim() === '1') {
        alert('success','Event has been removed');
        get_event(); // Ensure get_events is correctly called to refresh the list
      } else {
        alert('error','Unable to remove event');
      }
    };

    xhr.onerror = function() {
      confirmModal.hide();
      alert('An error occurred. Please try again.');
    };

    xhr.send(data);
  };
}


function view_details(id) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/bookings_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
    if (this.status === 200) {
      try {
        let response = JSON.parse(this.responseText);
        if (response.error) {
          alert('Error', response.error); // Display error message if present
        } else {
          displayBookingDetails(response); // Display booking details
        }
      } catch (e) {
        alert('Error', 'Error parsing response'); // Handle parsing error
      }
    } else {
      alert('Error', 'Failed to fetch booking details'); // Handle AJAX request failure
    }
  };

  xhr.send('view_details=' + id);
}

function displayBookingDetails(booking) {
  // Populate modal with booking details
  let modalBody = document.querySelector('#bookingDetailsModal .modal-body');
  let modalContent = `
    <p><strong>Booking ID:</strong> ${booking.id}</p>
    <p><strong>Event Name:</strong> ${booking.event_name}</p>
    <p><strong>Customer Name:</strong> ${booking.customer_name}</p>
    <p><strong>Booking Date:</strong> ${booking.booking_date}</p>
    <p><strong>Price:</strong> ${booking.price}</p>
    <p><strong>Status:</strong> ${booking.status === '1' ? 'Confirmed' : 'Pending'}</p>
  `;

  modalBody.innerHTML = modalContent;

  // Show the modal
  let bookingDetailsModal = new bootstrap.Modal(document.getElementById('bookingDetailsModal'));
  bookingDetailsModal.show();
}














