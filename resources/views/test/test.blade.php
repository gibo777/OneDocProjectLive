{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<x-app-layout>

<x-jet-button id="exportExcel" class="my-3">Export to Excel</x-jet-button>

<div id="table-container">
  <table id="exportTable">
    <thead class="thead">
      <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>30</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Jane</td>
        <td>25</td>
        <td>jane@example.com</td>
      </tr>
      <tr>
        <td>Doe</td>
        <td>40</td>
        <td>doe@example.com</td>
      </tr>
    </tbody>
  </table>
</div>




<script type="text/javascript">

 $(document).ready(function() {

    // var table = $('#exportTable').DataTable();


  // Event listener for button click
  $('#exportExcel').click(function() {
    var blob = new Blob([$('#table-container').html()], { type: 'application/vnd.ms-excel' });
    var url = window.URL.createObjectURL(blob);

    // Create a download link
    var a = document.createElement('a');
    a.href = url;
    a.download = 'data.xls'; // Use .xls extension for Excel files
    document.body.appendChild(a);
    a.click();

    // Clean up
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
  });
});


</script>

</x-app-layout>