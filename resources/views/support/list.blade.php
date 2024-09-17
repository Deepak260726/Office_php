@extends('layouts.app')

@section('content')
<script>
$(document).ready(function() {
  console.log("Document is ready"); // Debugging statement

  function searchBarcode(query) {
    console.log("Searching for:", query); // Debugging statement
    $.ajax({
      type: 'GET',
      url: "{{ url('/support/search') }}",
      data: { barcode: query },
      success: function(data) {
        console.log("AJAX Success:", data); // Debugging statement
        
        let listContainer = $('#search-results-list');
        
        if (data.results && data.results.length > 0) {
          listContainer.empty(); // Clear previous results

          // Populate the list with new results
          data.results.forEach(function(result) {
            let statusClass = result.barcodeOk === 'Y' ? 'badge-success' : 'badge-secondary';
            let statusText = result.barcodeOk;
            
            listContainer.append(
            `<li class="list-group-item mb-3 border rounded p-3">
              <div class="result-item">
                <div class="key-value">
                  <strong class="key">BarCode:</strong>
                  <span class="value">${result.barcodeNumber}</span>
                </div>
                <div class="key-value">
                  <strong class="key">Name:</strong>
                  <span class="value">${result.barcodeName}</span>
                </div>
                <div class="key-value">
                  <strong class="key">BarCodeOK:</strong>
                  <span class="badge ${statusClass}">${statusText}</span>
                </div>
              </div>
              <div class="mt-2 d-flex justify-content-end">
                <button class="btn btn-success btn-sm mr-2" type="button">OK</button>
                <button class="btn btn-danger btn-sm" type="button">Not OK</button>
              </div>
            </li>`
          );
        

          });

          $('#search-results-list').removeClass('d-none'); // Show the list
          $('#no-results-message').addClass('d-none'); // Hide no results message
        } else {
          $('#search-results-list').addClass('d-none'); // Hide the list
          $('#no-results-message').removeClass('d-none'); // Show no results message
        }
      },
      error: function(xhr, status, error) {
        console.error("AJAX Error:", status, error);
        $('#search-results').html('<div class="alert alert-danger">An error occurred while searching. Please try again.</div>');
      }
    });
  }

  $('#search-button').click(function() {
    var query = $('#search-input').val().trim();
    console.log('Search query:', query); // Debugging statement
    if (query) {
      searchBarcode(query);
    } else {
      $('#search-results').html('<div class="alert alert-warning">Please enter a barcode to search.</div>');
    }
  });

  $('#search-input').keypress(function(e) {
    if (e.which === 13) { // Enter key pressed
      $('#search-button').click();
    }
  });
});
</script>

<div class="container-fluid px-0">
  <div class="px-5 mx-5">
    <div class="row page-header">
      <div class="col-12 mt-7">
        <div class="card py-3 px-3">
          <!-- Search Bar -->
          <div class="input-group mb-3" style="margin-top: 10px;">
            <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Search by barcode" aria-label="Search" aria-describedby="search-addon" style="max-width: 350px; height: 34px; margin-right: 15px; margin-left: 10px;">
            <div class="input-group-append">
              <button id="search-button" class="btn btn-primary btn-sm" type="button" style="height: 34px; padding-left: 20px; padding-right: 20px;">Search</button>
            </div>
          </div>

          <!-- Placeholder for Search Results -->
          <div id="search-results" class="mt-3">
            <ul class="list-group d-none" id="search-results-list">
              <!-- Data items will be injected here -->
            </ul>
            <div id="no-results-message" class="d-none">
              <div class="alert alert-info">No results found.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  /* CSS from the previous response */
  .list-group-item {
    background-color: #f9f9f9;
    padding: 15px;
    border: 1px solid #ddd;
  }

  .result-item {
    display: flex;
    flex-direction: column;
  }

  .key-value {
    display: flex;
    align-items: center;
    margin-bottom: 10px; /* Space between each key-value pair */
  }

  .key {
    font-weight: bold;
    margin-right: 10px; /* Space between key and value */
    min-width: 100px; /* Ensures key has enough space to be visible */
  }

  .value {
    flex: 1; /* Allow value to take remaining space */
  }

  .badge {
    font-size: 0.8rem;
  }

  .btn-success {
    margin-right: 10px;
  }
</style>





@endsection
