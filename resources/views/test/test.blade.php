<!-- SweetAlert CSS -->
<link rel="stylesheet" href="path/to/sweetalert.css">

<!-- Magnify.js CSS -->
<link rel="stylesheet" href="path/to/magnify.css">

<!-- jQuery (required by Magnify.js) -->
<script src="path/to/jquery.min.js"></script>

<!-- SweetAlert and Magnify.js scripts -->
<script src="path/to/sweetalert.min.js"></script>
<script src="path/to/magnify.min.js"></script>

<style type="text/css">
    table {
      width: 100%;
      border-collapse: collapse;
    }

    td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }

    .zoomable-image {
      max-width: 100px;
      cursor: pointer;
    }
</style>

<table>
  <tr>
    <td>
      <img class="zoomable-image" src="https://upload.wikimedia.org/wikipedia/en/d/d6/Superman_Man_of_Steel.jpg">
    </td>
    <td>
      <!-- Other content -->
    </td>
  </tr>
</table>
<button onclick="showZoomableImage()">Show Zoomable Image</button>

<script type="text/javascript">
    function showZoomableImage() {
  const content = `
    <table>
      <tr>
        <td>
          <img class="zoomable-image" src="https://upload.wikimedia.org/wikipedia/en/d/d6/Superman_Man_of_Steel.jpg">
        </td>
        <td>
          <!-- Other content -->
        </td>
      </tr>
    </table>`;

  Swal.fire({
    html: content,
    showConfirmButton: false,
    onOpen: () => {
      // Initialize Magnify.js on the image
      $('.zoomable-image').magnify();
    }
  });
}

</script>
