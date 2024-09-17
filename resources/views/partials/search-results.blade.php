<table class="table table-striped">
  <thead>
    <tr>
      <th>BarCode</th>
      <th>Name</th> <!-- Adjust based on your model fields -->
    </tr>
  </thead>
  <tbody>
    @forelse($results as $result)
      <tr>
        <td>{{ $result->barcodeNumber }}</td>
        <td>{{ $result->barcodeName }}</td> <!-- Adjust based on your model fields -->
      </tr>
    @empty
      <tr>
        <td colspan="2">No results found.</td>
      </tr>
    @endforelse
  </tbody>
</table>
