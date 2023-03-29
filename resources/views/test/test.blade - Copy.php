<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="jquery.twbsPagination.min.js"></script>

<table id="employee" class="table table-bordered table table-hover" cellspacing="0" width="100%">
     <colgroup><col><col><col></colgroup>
      <thead>
      <tr>
            <th>Name</th>
            <th >Salary</th>
            <th>Age</th>
      </tr>
      </thead>
      <tbody id="emp_body">
      </tbody>
</table>
<div id="pager">
      <ul id="pagination" class="pagination-sm"></ul>
</div>



<script type="text/javascript">
      var $pagination = $('#pagination'),
totalRecords = 0,
records = [],
displayRecords = [],
recPerPage = 10,
page = 1,
totalPages = 0;
$.ajax({
      url: "http://dummy.restapiexample.com/api/v1/employees",
      async: true,
      dataType: 'json',
      success: function (data) {
                  records = data;
                  console.log(records);
                  totalRecords = records.length;
                  totalPages = Math.ceil(totalRecords / recPerPage);
                  apply_pagination();
      }
});

function generate_table() {
      var tr;
      $('#emp_body').html('');
      for (var i = 0; i < displayRecords.length; i++) {
            tr = $('<tr/>');
            tr.append("<td>" + displayRecords[i].employee_name + "</td>");
            tr.append("<td>" + displayRecords[i].employee_salary + "</td>");
            tr.append("<td>" + displayRecords[i].employee_age + "</td>");
            $('#emp_body').append(tr);
      }
}
function apply_pagination() {
      $pagination.twbsPagination({
            totalPages: totalPages,
            visiblePages: 6,
            onPageClick: function (event, page) {
                  displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
                  endRec = (displayRecordsIndex) + recPerPage;
                 
                  displayRecords = records.slice(displayRecordsIndex, endRec);
                  generate_table();
            }
      });
}
</script>